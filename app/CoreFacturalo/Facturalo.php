<?php

namespace App\CoreFacturalo;
use Illuminate\Support\Facades\Storage;

use App\CoreFacturalo\Helpers\QrCode\QrCodeGenerate;
use App\CoreFacturalo\Helpers\Xml\XmlFormat;
use App\CoreFacturalo\Helpers\Xml\XmlHash;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\CoreFacturalo\WS\Client\WsClient;
use App\CoreFacturalo\WS\Services\BillSender;
use App\CoreFacturalo\WS\Services\ConsultCdrService;
use App\CoreFacturalo\WS\Services\ExtService;
use App\CoreFacturalo\WS\Services\SummarySender;
use App\CoreFacturalo\WS\Services\SunatEndpoints;
use App\CoreFacturalo\WS\Signed\XmlSigned;
use App\CoreFacturalo\WS\Validator\XmlErrorCodeProvider;
use App\Models\Company;
use App\Mail\Tenant\DocumentEmail;
use App\Models\Tenant\Establishment;
use Illuminate\Support\Facades\Mail;
use App\Models\Tenant\Dispatch;
use App\Models\Tenant\DispatchItem;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\Tenant\DocumentSoapToken;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\OperationCampoItem;
use App\Models\Tenant\Retention;
use App\Models\Tenant\Quotation;
use App\Models\Tenant\QuotationItem;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Summary;
use App\Models\Tenant\Voided;
use Exception;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Models\InventoryConfiguration;

class Facturalo
{
    use StorageDocument;

    const REGISTERED = '01';
    const OBSERVED = '07';
    const SENT = '03';
    const ACCEPTED = '05';


    //original const CANCELING = '13';
    const CANCELING = '11';


    const VOIDED = '11';
    const REJECTED = '09';

    protected $company;
    protected $isDemo;
    protected $isOse;
    protected $signer;
    protected $wsClient;
    protected $document;
    protected $insertedItems = [];
    protected $type;
    protected $actions;
    protected $xmlUnsigned;
    protected $xmlSigned;
    protected $pathCertificate;
    protected $soapUsername;
    protected $soapPassword;
    protected $endpoint;
    protected $response;

    //Cuando se trate de una anulacion, esta variable servirá para identificar
    //si dicho comprobante ya fue anulado anterior en base a las tablas
    //summary_documents(con summary de anulacion), y voided_documents
    protected $previousVoided = false;

    public function __construct()
    {
        $this->company = Company::active();
        $this->isDemo = ($this->company->soap_type_id === '01') ? true : false;
        $this->isOse = ($this->company->soap_send_id === '02') ? true : false;
        // $this->signer = new XmlSigned();
        // $this->wsClient = new WsClient();//ORIGINAL
        // $this->wsClient = new WsClient('', array('trace' => 1));
        $this->setDataSoapType();
    }

    public function setDocument($document)
    {
        $this->document = $document;
    }

    public function setActions($actions){
        $this->actions = $actions;
    }

    public function getDocument()
    {
        return $this->document;
    }
    public function getInsertedItems(){
        return $this->insertedItems;
    }
    private function addInsertedItem( $item ){
        array_push(  $this->insertedItems, $item  );
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setPreviousVoided($value){
        $this->previousVoided = $value;
    }


    public function save($inputs)
    {
        $this->actions = array_key_exists('actions', $inputs) ? $inputs['actions'] : [];
        $this->type = $inputs['type'];
        switch ($this->type) {
            case 'debit':
            case 'credit':

                $document = Document::create($inputs);
                foreach ($inputs['items'] as $row) {
                    $docItem = $document->items()->create($row);

                    foreach ($row["adicionales_seleccionados"] as $adicional_seleccionado) {
                        //cambiar de estado 2 | Devolucion
                        if( $adicional_seleccionado["checked"] ){
                            $ope_campo_item = OperationCampoItem::where(
                                'operation_campo_item_id','=',$adicional_seleccionado["operation_campo_item_id"]
                            )->first();
                            if( $ope_campo_item ){
                                OperationCampoItem::find($adicional_seleccionado["sale_operation_campo_item_id"])
                                ->update(['sale_voided_date'=> $inputs['date_of_issue']. ' '. $inputs['time_of_issue'] ]);

                                //restaurar purchases
                                $purchases = OperationCampoItem::where('id','=', $ope_campo_item->operation_campo_item_id );
                                if($purchases){
                                    $purchases->update(["estado"=>2]);
                                }
                            }

                        };
                    }

                    $this->saveVariation($docItem, $row);
                }

                $document->note()->create($inputs['note']);

                $this->document = Document::find($document->id);

                if($this->type=='credit')$this->restoreDocumentStock();

                break;
            case 'invoice':
                $document = Document::create($inputs);

                foreach ($inputs['items'] as $row) {

                    //$document->items()->create($row);
                    $docItem = new DocumentItem;
                    $docItem->fill( $row );
                    $docItem->document_id = $document->id;
                    $docItem->save();

                    $this->addInsertedItem( $docItem );
                    // $this->saveVariation($docItem, $row);
                    // $this->saveSubitems($document, $docItem);

                }
                $document->invoice()->create($inputs['invoice']);
                $this->document = Document::find($document->id);
                break;


            case 'summary':

                $document = Summary::create($inputs);
                foreach ($inputs['documents'] as $row) {
                    $document->documents()->create($row);
                }
                $this->document = Summary::find($document->id);
				$this->restoreDocumentStock();
                break;

            case 'voided':
                $document = Voided::create($inputs);
                foreach ($inputs['documents'] as $row) {
                    $document->documents()->create($row);
                }
                $this->document = Voided::find($document->id);
                $this->restoreDocumentStock();
                break;
            case 'retention':
                $document = Retention::create($inputs);
                foreach ($inputs['documents'] as $row) {
                    $document->documents()->create($row);
                }
                $this->document = Retention::find($document->id);
                break;
            case 'quotation':
                $document = Quotation::create($inputs);
                foreach ($inputs['items'] as $row) {
                    //$document->items()->create($row);
                    $docItem = new QuotationItem;
                    $docItem->fill( $row );
                    $docItem->quotation_id = $document->id;
                    $docItem->save();
                    $this->saveVariation($docItem, $row);
                }
                $this->document = Quotation::find($document->id);
                break;
            case 'sale-note':
                $document = SaleNote::create($inputs);
                foreach ($inputs['items'] as $row) {
                    //$document->items()->create($row);
                    $docItem = new SaleNoteItem;
                    $docItem->fill( $row );
                    $docItem->sale_note_id = $document->id;
                    $docItem->save();

                    $this->addInsertedItem( $docItem );
                    $this->saveVariation($docItem, $row);
                    $this->saveSubitems($document, $docItem);

                }
                $this->document = SaleNote::find($document->id);
                break;
            default:
                $document = Dispatch::create($inputs);

                foreach ($inputs['items'] as $row) {
                    //$document->items()->create($row);
                    $docItem = new DispatchItem;
                    $docItem->fill( $row );
                    $docItem->dispatch_id = $document->id;
                    $docItem->save();

                    $this->saveVariation($docItem, $row);
                }
                $this->document = Dispatch::find($document->id);
                break;
        }
    }

    public function restoreDocumentStock(){


        if( isset($this->document->summary_status_type_id) ){
            if( $this->document->summary_status_type_id != "03" )return;
        }

        if( $this->previousVoided ){
            return;
        }

        $documents = [];
        $isCreditOrDebit = false;

        if( in_array($this->type,['credit','debit']) ){
            $isCreditOrDebit = true;
            array_push($documents, $this->document );
        }else{
            $documents = $this->document->documents()->get();
        }

        foreach ( $documents as $doc) {

            //restaurar stock de variaciones
            //$document_items = $isCreditOrDebit ? $doc->items()->whereHas('variations')->get() : $doc->document->items()->whereHas('variations')->get();
            $document_items = $isCreditOrDebit ? $doc->items()->get() : $doc->document->items()->get();


            foreach ($document_items as $item) {

                //instancia de [\App\Models\Tenant\Document]
                $document = $item->document;

                foreach ( $item->variations()->get()  as $variation) {
                    $update_variation_stock = $variation->variation_stock;
                    $update_variation_stock->stock+=$variation->quantity;
                    $update_variation_stock->save();
                }

                //restore subitems stock
                //al crear el resgistro Inventory hay un listener que hace
                //que se restaure el stock aparte de registrar en Inventory
                foreach ( $item->subitems()->get() as $subitem) {

                    $inventory = new \Modules\Inventory\Models\Inventory();
                    $inventory->type = 4;
                    $inventory->description = 'Aumentar';
                    $inventory->item_id = $subitem->item_id;
                    $inventory->warehouse_id = $document->establishment_id;
                    $inventory->quantity = $subitem->quantity;
                    $inventory->save();
                }

            }

        }

    }

    public function saveVariation($item, $row_item){

        $input_document_type = $this->type;

        foreach ( $row_item['variation_stock'] as $variation) {

            $variation_stock_id_by_document_type = [
                'invoice' => $variation['variation_stock_id'] ?? $variation['id']??null,
                'credit' => $variation['variation_stock_id']??null,
                'dispatch' => $variation['variation_stock_id'] ?? $variation['id'] ?? null,
                'quotation' => $variation['id']??null,
                'sale-note' =>  $variation['id']??null
            ];

            $data_variation = [
                'variation_stock_id'=> $variation_stock_id_by_document_type[$input_document_type] ,
                'quantity' => $variation['quantity']
            ];
            $item->variations()->create($data_variation);
        }

    }


    public function saveSubitems($document, $document_item){

        $item = $document_item->relation_item;

        if( !$item->use_subitems )return;

        foreach ($item->subitems as $subitem) {

            $quantity = -1 * ($subitem->quantity * $document_item->quantity);

            //si funciona todo ok, migrar la funcionalidad para reducir
            //el codigo llamando a los Trait

            //register invetory kardex subitem
            $document->inventory_kardex()->create([
                'date_of_issue' => date('Y-m-d'),
                'item_id' => $subitem->item_id,
                'warehouse_id' => $document->establishment_id,
                'quantity' => $quantity,
            ]);

            //update stock subitem
            $inventory_configuration = InventoryConfiguration::firstOrFail();

            $item_warehouse = ItemWarehouse::firstOrNew(['item_id' => $subitem->item_id, 'warehouse_id' => $document->establishment_id]);
            $item_warehouse->stock = $item_warehouse->stock + $quantity;

            if( $quantity < 0 ){
                if (($inventory_configuration->stock_control) && ($item_warehouse->stock < 0)){
                    throw new Exception("El producto {$item_warehouse->item->description} no tiene suficiente stock!");
                }
            }
            $item_warehouse->save();

            //register document_item_subitem
            $document_item->subitems()->create(['item_id'=>$subitem->item_id,'quantity'=> $subitem->quantity * $document_item->quantity ]);
        }

    }


    public function updateQuotation($inputs, $quotation_id)
    {
        //eliminar
        Quotation::where('id', $quotation_id)->delete();
        QuotationItem::where('quotation_id', $quotation_id)->delete();

        //crear
        $document = Quotation::create($inputs);

        foreach ($inputs['items'] as $row) {
            $newItem = $document->items()->create($row);

            foreach ($row['variation_stock'] as $variation) {

                $variation_stock_id = isset($row['id']) ? $variation['variation_stock_id'] : $variation['id'];

                $data_variation = [
                    'variation_stock_id'=>$variation_stock_id,
                    'quantity' => $variation['quantity']
                ];
                $newItem->variations()->create($data_variation);
            }

        }

        $this->documento = Quotation::find($document->id);

        return $this->documento;
    }

    public function sendEmail()
    {
        $send_email = ($this->actions['send_email'] === true) ? true : false;

        if ($send_email) {

            $company = $this->company;
            $document = $this->document;
            $email = ($this->document->customer) ? $this->document->customer->email : $this->document->supplier->email;

            Mail::to($email)->send(new DocumentEmail($company, $document));
        }
    }

    public function createXmlUnsigned()
    {
        // $template = new Template();
        // $this->xmlUnsigned = XmlFormat::format($template->xml($this->type, $this->company, $this->document));
        // $this->uploadFile($this->xmlUnsigned, 'unsigned');
    }

    public function signXmlUnsigned()
    {
        // $this->setPathCertificate();
        // $this->signer->setCertificateFromFile($this->pathCertificate);
        // $this->xmlSigned = $this->signer->signXml($this->xmlUnsigned);

        // $this->uploadFile($this->xmlSigned, 'signed');
    }

    public function updateHash()
    {
        $this->document->update([
            'hash' => $this->getHash(),
        ]);
    }

    public function updateQr()
    {
        $this->document->update([
            'qr' => $this->getQr(),
        ]);
    }

    public function updateState($state_type_id)
    {
        $this->document->update([
            'state_type_id' => $state_type_id
        ]);
    }

    public function updateStateDocuments($state_type_id)
    {

        foreach ($this->document->documents as $doc) {
            $doc->document->update([
                'state_type_id' => $state_type_id
            ]);
        }
    }

    private function getHash()
    {
        // $helper = new XmlHash();
        // return $helper->getHashSign($this->xmlSigned);
    }

    private function getQr()
    {
        $customer = $this->document->customer;
        $text = join('|', [
            $this->company->number,
            $this->document->document_type_id,
            $this->document->series,
            $this->document->number,
            $this->document->total_igv,
            $this->document->total,
            $this->document->date_of_issue->format('Y-m-d'),
            $customer->identity_document_type_id,
            $customer->number,
            $this->document->hash
        ]);

        $qrCode = new QrCodeGenerate();
        $qr = $qrCode->displayPNGBase64($text);
        return $qr;
    }

    public function createPdf($document = null, $type = null, $format = null)
    {
        $template = new Template();
        $pdf = new Mpdf();

        $format_pdf = $this->actions['format_pdf'];

        $this->document = ($document != null) ? $document : $this->document;
        $format_pdf = ($format != null) ? $format : $format_pdf;


        $this->type = ($type != null) ? $type : $this->type;

        $pdf_horinzontal_margin = 5;

        $html = $template->pdf($this->type, $this->company, $this->document, $format_pdf);

        if ($format_pdf === 'ticket') {



            $company_name = (strlen($this->company->name) / 20) * 10;
            $company_address = (strlen($this->document->establishment->address) / 30) * 10;
            $company_number = $this->document->establishment->telephone != '' ? '10' : '0';
            $customer_name = strlen($this->document->customer->name) > '25' ? '10' : '0';
            $customer_address = (strlen($this->document->customer->address) / 200) * 10;
            $p_order = $this->document->purchase_order != '' ? '10' : '0';

            $total_exportation = $this->document->total_exportation != '' ? '10' : '0';
            $total_free = $this->document->total_free != '' ? '10' : '0';
            $total_unaffected = $this->document->total_unaffected != '' ? '10' : '0';
            $total_exonerated = $this->document->total_exonerated != '' ? '10' : '0';
            $total_taxed = $this->document->total_taxed != '' ? '10' : '0';
            $quantity_rows = count($this->document->items);
            $discount_global = 0;
            // dd($this->document->items);
            foreach ($this->document->items as $it) {
                if ($it->discounts) {
                    $discount_global = $discount_global + 1;
                }
            }
            $legends = $this->document->legends != '' ? '10' : '0';
            $default_height = 120;
            $height_legend = 0;

            //aplicar margenes horizontales mas pequeños en la guia
            if( $this->type == 'dispatch' ){
                $pdf_horinzontal_margin = 1;
                $height_legend = 10;
                $default_height = 180;
            }



            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    78,
                    /*120*/ $default_height +
                        ($quantity_rows * 8) +
                        ($discount_global * 3) +
                        $company_name +
                        $company_address +
                        $company_number +
                        $customer_name +
                        $customer_address +
                        $p_order +
                        $legends +
                        $total_exportation +
                        $total_free +
                        $total_unaffected +
                        $total_exonerated +
                        $total_taxed +
                        $height_legend
                ],
                'margin_top' => 2,
                'margin_right' => $pdf_horinzontal_margin,
                'margin_bottom' => 0,
                'margin_left' => $pdf_horinzontal_margin
            ]);
        }

        $pdf->WriteHTML($html);

        if ($format_pdf != 'ticket') {
            $html_footer = $template->pdfFooter();
            $pdf->SetHTMLFooter($html_footer);
        }
        $this->uploadFile($pdf->output('', 'S'), 'pdf');
    }

    public function createPdf2($document = null, $type = null, $format = null)
    {
        $template = new Template();
        $pdf = new Mpdf();

        $format_pdf = $this->actions['format_pdf'];

        $this->document = ($document != null) ? $document : $this->document;

        $format_pdf = ($format != null) ? $format : $format_pdf;
        $this->type = ($type != null) ? $type : $this->type;

        $html = $template->pdf('simple', $this->company, $this->document, $format_pdf);

        if ($format_pdf === 'ticket') {

            $company_name = (strlen($this->company->name) / 20) * 10;
            $company_address = (strlen($this->document->establishment->address) / 30) * 10;
            $company_number = $this->document->establishment->telephone != '' ? '10' : '0';
            $customer_name = strlen($this->document->customer->name) > '25' ? '10' : '0';
            $customer_address = (strlen($this->document->customer->address) / 200) * 10;
            $p_order = $this->document->purchase_order != '' ? '10' : '0';

            $total_exportation = $this->document->total_exportation != '' ? '10' : '0';
            $total_free = $this->document->total_free != '' ? '10' : '0';
            $total_unaffected = $this->document->total_unaffected != '' ? '10' : '0';
            $total_exonerated = $this->document->total_exonerated != '' ? '10' : '0';
            $total_taxed = $this->document->total_taxed != '' ? '10' : '0';
            $quantity_rows = count($this->document->items);
            $discount_global = 0;
            foreach ($this->document->items as $it) {
                if ($it->discounts) {
                    $discount_global = $discount_global + 1;
                }
            }
            $legends = $this->document->legends != '' ? '10' : '0';

            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    78,
                    120 +
                        ($quantity_rows * 8) +
                        ($discount_global * 3) +
                        $company_name +
                        $company_address +
                        $company_number +
                        $customer_name +
                        $customer_address +
                        $p_order +
                        $legends +
                        $total_exportation +
                        $total_free +
                        $total_unaffected +
                        $total_exonerated +
                        $total_taxed
                ],
                'margin_top' => 2,
                'margin_right' => 5,
                'margin_bottom' => 0,
                'margin_left' => 5
            ]);
        }

        $pdf->WriteHTML($html);

        if ($format_pdf != 'ticket') {
            $html_footer = $template->pdfFooter();
            $pdf->SetHTMLFooter($html_footer);
        }

        $this->uploadFile($pdf->output('', 'S'), 'pdf');
    }
    public function depuration($var)
    {
        print_r($var);
        exit;
    }

    public function createTicketCollection($document = null, $type = null, $format = null, $payments)
    {

        // $this->depuration($format);

        $template = new Template();
        $pdf = new Mpdf();

        $format_pdf = $this->actions['format_pdf'];
        $this->document = ($document != null) ? $document : $this->document;
        $format_pdf = ($format != null) ? $format : $format_pdf;

        // $this->depuration($format_pdf);


        $this->type = ($type != null) ? $type : $this->type;


        $html = $template->pdf2($this->type, $this->company, $this->document, $format_pdf, $payments);
        $format_pdf = "ticket";

        if ($format_pdf === 'ticket') {

            $company_name = (strlen($this->company->name) / 20) * 10;
            $company_address = (strlen($this->document->establishment->address) / 30) * 10;
            $company_number = $this->document->establishment->telephone != '' ? '10' : '0';
            $customer_name = strlen($this->document->customer->name) > '25' ? '10' : '0';
            $customer_address = (strlen($this->document->customer->address) / 200) * 10;
            $p_order = $this->document->purchase_order != '' ? '10' : '0';

            // $total_exportation = $this->document->total_exportation != '' ? '10' : '0';
            // $total_free = $this->document->total_free != '' ? '10' : '0';
            // $total_unaffected = $this->document->total_unaffected != '' ? '10' : '0';
            // $total_exonerated = $this->document->total_exonerated != '' ? '10' : '0';
            // $total_taxed = $this->document->total_taxed != '' ? '10' : '0';
            $quantity_rows = count($this->document->items);
            $discount_global = 0;
            foreach ($this->document->items as $it) {
                if ($it->discounts) {
                    $discount_global = $discount_global + 1;
                }
            }
            $legends = $this->document->legends != '' ? '10' : '0';

            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    78,
                    120 +
                        ($quantity_rows * 8) +
                        ($discount_global * 3) +
                        $company_name +
                        $company_address +
                        $company_number +
                        $customer_name +
                        $customer_address +
                        $p_order +
                        $legends +
                        $payments
                ],
                'margin_top' => 2,
                'margin_right' => 5,
                'margin_bottom' => 0,
                'margin_left' => 5
            ]);
        }

        $pdf->WriteHTML($html);

        if ($format_pdf != 'ticket') {
            $html_footer = $template->pdfFooter();
            $pdf->SetHTMLFooter($html_footer);
        }
        $this->uploadFile($pdf->output('', 'S'), 'pdf');
    }



    public function createPdfWorkOrder($document = null, $type = null, $format = null)
    {
        // $this->depuration($format);
        $template = new Template();
        $pdf = new Mpdf();

        $format_pdf = $this->actions['format_pdf'];

        $this->document = ($document != null) ? $document : $this->document;
        $format_pdf = ($format != null) ? $format : $format_pdf;
        $this->type = ($type != null) ? $type : $this->type;


        $html = $template->pdf($this->type, $this->company, $this->document, $format_pdf);

        if ($format_pdf === 'ticket') {

            $company_name = (strlen($this->company->name) / 20) * 10;
            $company_address = (strlen($this->document->establishment->address) / 30) * 10;
            $company_number = $this->document->establishment->telephone != '' ? '10' : '0';
            $customer_name = strlen($this->document->customer->name) > '25' ? '10' : '0';
            $customer_address = (strlen($this->document->customer->address) / 200) * 10;
            $p_order = $this->document->purchase_order != '' ? '10' : '0';

            // $total_exportation = $this->document->total_exportation != '' ? '10' : '0';
            // $total_free = $this->document->total_free != '' ? '10' : '0';
            // $total_unaffected = $this->document->total_unaffected != '' ? '10' : '0';
            // $total_exonerated = $this->document->total_exonerated != '' ? '10' : '0';
            // $total_taxed = $this->document->total_taxed != '' ? '10' : '0';
            $quantity_rows = count($this->document->items);
            $discount_global = 0;
            foreach ($this->document->items as $it) {
                if ($it->discounts) {
                    $discount_global = $discount_global + 1;
                }
            }
            $legends = $this->document->legends != '' ? '10' : '0';

            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    78,
                    120 +
                        ($quantity_rows * 8) +
                        ($discount_global * 3) +
                        $company_name +
                        $company_address +
                        $company_number +
                        $customer_name +
                        $customer_address +
                        $p_order +
                        $legends
                ],
                'margin_top' => 2,
                'margin_right' => 5,
                'margin_bottom' => 0,
                'margin_left' => 5
            ]);
        }

        $pdf->WriteHTML($html);

        if ($format_pdf != 'ticket') {
            $html_footer = $template->pdfFooter();
            $pdf->SetHTMLFooter($html_footer);
        }
        $this->uploadFile($pdf->output('', 'S'), 'pdf');
    }


    public function loadXmlSigned()
    {
        $this->xmlSigned = $this->getStorage($this->document->filename, 'signed');
        //        dd($this->xmlSigned);
    }

    private function senderXmlSigned()
    {
        $this->setDataSoapType();
        $sender = in_array($this->type, ['summary', 'voided']) ? new SummarySender() : new BillSender();
        $sender->setClient($this->wsClient);
        $sender->setCodeProvider(new XmlErrorCodeProvider());
        // dd($sender);
        return $sender->send($this->document->filename, $this->xmlSigned);
    }

    public function senderXmlSignedBill()
    {
        if (!$this->actions['send_xml_signed']) {
            $this->response = [
                'sent' => false,
            ];
            return;
        }
        $this->onlySenderXmlSignedBill();
    }

    private function getSoapToken(){

        $success = false;
        $message = '';
        $expiredToken = false;
        $token = DocumentSoapToken::first();

        $uriGetToken = 'https://api-seguridad.sunat.gob.pe';

        if($token){

            $curerntTime = \Carbon\Carbon::now();
            $tokenCreatedAt = \Carbon\Carbon::parse($token->created_at);

            //cantidad de segundos que resta al tiempo de expiraion [expires_in]
            //Cuando ya falta 5 minutos por vencer el token se consultara nuevamente.No esperar
            //a que sea exatamente 1 hora para realizar la consulta del token
            $subtractSeconds = 180; //180 = 3 minutos

            $duration = $curerntTime->diffInSeconds($tokenCreatedAt);
            $expiredToken = $duration >= ($token->expires_in - $subtractSeconds);


            //si aún no expira el token deolver el token almacenado en la bd
            if( !$expiredToken )return $token;

        }


        $client =  new \GuzzleHttp\Client([
            'base_uri' => $uriGetToken,
        ]);
        try {

            $client_id = $this->company->soap_client_id;
            $client_secret = $this->company->soap_secret_key;
            $soap_username = $this->company->soap_username;
            $soap_password = $this->company->soap_password;


            $endpoint = '/v1/clientessol/'.$client_id.'/oauth2/token/';

            $response = $client->request('POST', $endpoint, [
                'headers' => [
                    //corregir esto, porque es Accept, pero igual se obtiene el token ._.
                    'Accpet' => 'application/json'
                ],
                'form_params' => [
                    'grant_type' => 'password',
                    'scope' => 'https://api-cpe.sunat.gob.pe/',
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                    'username' => $soap_username,
                    'password' => $soap_password
                ]
            ]);

            if ($response->getStatusCode() == 200 && $response != "") {

                $response = $response->getBody()->getContents();
                $parsedResponse = json_decode( $response );

                $success = true;
                $tokenResponse = $parsedResponse;

                //limpiar y almacenar token
                DocumentSoapToken::query()->delete();
                $token = DocumentSoapToken::create([
                    'access_token'=> $tokenResponse->access_token,
                    'expires_in'=> $tokenResponse->expires_in,
                ]);

            }


        }catch( \GuzzleHttp\Exception\ClientException $ex){

            $response = $ex->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $parsedResponse = json_decode( $responseBodyAsString );

            $success = false;
            $message = $parsedResponse->error_description ?? $parsedResponse->msg;

        } catch (\Exception $ex) {
            $success = false;
            $message = $ex->getMessage();
        }


        if( !$success ){
            throw new Exception($message);
        }

        return $token;
    }

    public function sendDispatch()
    {

        $token = $this->getSoapToken();
        $success = false;
        $message = '';

        $uriSendDocuments = 'https://api-cpe.sunat.gob.pe';

        $accessToken= $token->access_token;
        $sendDocumentClient =  new \GuzzleHttp\Client([
            'base_uri' => $uriSendDocuments,
        ]);
        try {

            $compressor = new \App\CoreFacturalo\WS\Zip\ZipFly();

            $fileName = $this->document->filename;

            /*$arcGreZip = base64_encode( $compressor->compress($fileName.'.xml', $this->xmlSigned ) );
            $hashZip = hash('sha256', $arcGreZip);*/

            $arcGreZip =  $compressor->compress($fileName.'.xml', $this->xmlSigned ) ;
            $hashZip = hash('sha256', $arcGreZip);
            $arcGreZip = base64_encode($arcGreZip);


            $endpoint = '/v1/contribuyente/gem/comprobantes/'.$fileName;


            $response = $sendDocumentClient->request('POST', $endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'json' => [
                    'archivo' => [
                        'nomArchivo' => $fileName . '.zip',
                        'arcGreZip' => $arcGreZip,
                        'hashZip' => $hashZip
                    ]
                ]
            ]);

            if ($response->getStatusCode() == 200 && $response != "") {

                $response = $response->getBody()->getContents();
                $parsedResponse = json_decode( $response );


                $this->updateTicket($parsedResponse->numTicket);
                $this->updateState( self::SENT );

                $success = true;
            }


        }catch( \GuzzleHttp\Exception\ClientException $ex){

            $response = $ex->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $parsedResponse = json_decode( $responseBodyAsString );

            if( empty($parsedResponse->errors) ){
                //$message = $parsedResponse->msg;
                $message = $parsedResponse->message;
            }else{
                $msg_error = $parsedResponse->errors[0];
                $msg_error_code = $msg_error->cod;
                $msg_error_msg = $msg_error->msg;
                $message = "Code: {$msg_error_code}; Description: {$msg_error_msg}";
            }

            $success = false;

        } catch (\Exception $ex) {
            $success = false;
            $message = $ex->getMessage();
        }


        if( !$success ) throw new Exception($message);

        $this->response = [
            'sent' => true,
            'description' => 'Guia de remisión enviada correctamente'
        ];

    }

    public function consultDispatchTicket(){

        $token = $this->getSoapToken();
        $accessToken = $token->access_token;

        $sendDocumentClient =  new \GuzzleHttp\Client([
            'base_uri' => 'https://api-cpe.sunat.gob.pe',
        ]);
        try {

            $endpoint = '/v1/contribuyente/gem/comprobantes/envios/'.$this->document->ticket;

            $response = $sendDocumentClient->request('GET', $endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ]
            ]);

            if ($response->getStatusCode() == 200 && $response != "") {

                $response = $response->getBody()->getContents();
                $parsedResponse = json_decode( $response );

                $cdrNotesString = '';

                if( !empty( $parsedResponse->arcCdr ?? '' ) ){

                    $this->document->has_cdr = 1;
                    $this->document->save();

                    $this->uploadFile( base64_decode($parsedResponse->arcCdr) , 'cdr');
                    $this->updateDispatchQrFromCdr();


                    $cdrXmlContent = $this->getXmlFromCdr($this->document->filename);

                    if( $cdrXmlContent ){
                        $description = $cdrXmlContent['description'];
                        if( !empty($cdrXmlContent['notes']) ) $cdrNotesString = implode(', ',  $cdrXmlContent['notes'] );
                    }

                }

                if( isset($parsedResponse->error) ){
                    $success = false;
                    $message = $parsedResponse->error->desError;
                    $this->updateState( self::SENT );
                    throw new Exception($message);
                }

                $this->updateState( self::ACCEPTED );

                $success = true;

                if( !empty($cdrNotesString) ){
                    //en la descripcion de la respuesta concatenar las obs de sunat para que el usuario pueda mirar
                    $description .= ' - ' . $cdrNotesString;
                }

                $this->response = [
                    'sent' => $success,
                    'code' => $parsedResponse->codRespuesta,
                    'description' => $description ?? 'Enviado correctamente'
                ];

            }

        } catch (\Exception $ex) {
            $success = false;
            $message = $ex->getMessage();
        }


        if( !$success ) throw new Exception($message);
    }

    public function updateDispatchQrFromCdr(){

        $cdrXmlContent = $this->getXmlContentFromCdr($this->document->filename);
        if( !$cdrXmlContent )return;

        $simpleXmlObject = new \SimpleXMLElement($cdrXmlContent);
        $cacNameSpaces = $simpleXmlObject->children('cac',true);
        $cacResponse = $cacNameSpaces->DocumentResponse->DocumentReference;
        $cbcNodes = $cacResponse->children('cbc',true);

        $linkQr = (string)$cbcNodes->DocumentDescription;

        if( empty($linkQr) )return;


        $qrCode = new QrCodeGenerate();
        $qr = $qrCode->displayPNGBase64($linkQr);

        $this->document->update([
            'qr' => $qr,
        ]);

    }

    public function onlySenderXmlSignedBill()
    {
        $res = $this->senderXmlSigned();
        if ($res->isSuccess()) {
            $cdrResponse = $res->getCdrResponse();
            $this->uploadFile($res->getCdrZip(), 'cdr');
            $this->updateState(self::ACCEPTED);

            $this->document->has_cdr = 1;
            $this->document->save();

            $cdrXmlContent = $this->getXmlFromCdr($this->document->filename);
            if( $cdrXmlContent ){
                if( $cdrXmlContent['code'] == 0 ){
                    $this->document->update(['accepted_in_cdr' => 1]);
                }
            }


            $this->response = [
                'sent' => true,
                'code' => $cdrResponse->getCode(),
                'description' => $cdrResponse->getDescription(),
                'notes' => $cdrResponse->getNotes()
            ];
        } else {
            throw new Exception("Code: {$res->getError()->getCode()}; Description: {$res->getError()->getMessage()}");
        }
    }

    public function senderXmlSignedSummary()
    {
        $res = $this->senderXmlSigned();
        // dd('senderXmlSignedSummary', $res);
        if ($res->isSuccess()) {
            $ticket = $res->getTicket();
            $this->updateTicket($ticket);
            $this->updateState(self::SENT);
            if ($this->type === 'summary') {
                if ($this->document->summary_status_type_id === '1') {
                    $this->updateStateDocuments(self::SENT);
                } else {
                    $this->updateStateDocuments(self::CANCELING);
                }
            } else {
                $this->updateStateDocuments(self::CANCELING);
            }
            $this->response = [
                'sent' => true
            ];
        } else {
            throw new Exception("Code: {$res->getError()->getCode()}; Description: {$res->getError()->getMessage()}");
        }
    }

    private function updateTicket($ticket)
    {
        $this->document->update([
            'ticket' => $ticket
        ]);
    }

    public function statusSummary($ticket)
    {
        $extService = new ExtService();
        $extService->setClient($this->wsClient);
        $extService->setCodeProvider(new XmlErrorCodeProvider());
        $res = $extService->getStatus($ticket);
        if (!$res->isSuccess()) {

            if ($res->getError()->getCode() == '0127' && $this->type === 'summary') {

                if ($this->document->summary_status_type_id === '1') {
                    $this->updateState(self::ACCEPTED);
                    $this->updateStateDocuments(self::ACCEPTED);

                    $this->response = [
                        'code' => 'not_found_ticket',
                        'description' => 'Comprobantes enviados, Cdr no descargado',
                        'notes' => ''
                    ];
                } else {

                    throw new Exception("Code: {$res->getError()->getCode()}; Description: {$res->getError()->getMessage()}");
                }
            }else{

                $errorDescription = $res->getError()->getMessage();

                /**
                98 = El procesamiento del comprobante aún no ha terminado.
                0200 = No se pudo procesar su solicitud.(Ocurrio un error en el batch).
                0100 = El sistema no puede responder su solicitud. Intente nuevamente o comuníquese con su Administrador.
                */

                if( in_array( (int)$res->getError()->getCode() , [98, 200, 100] ) ){
                    $errorDescription = 'Actualmente la plataforma de recepción de Sunat esta fallando, por favor intentar mas tarde o espere 24 horas.';
                }

                throw new Exception("Code: {$res->getError()->getCode()}; Description: $errorDescription");
            }

        } else {
            $cdrResponse = $res->getCdrResponse();

            $success = true;

            $this->uploadFile($res->getCdrZip(), 'cdr');

            $this->document->has_cdr = 1;
            $this->document->save();


            if( $cdrResponse->getCode() == 0 ){

                $this->updateState(self::ACCEPTED);

                $update_column = $this->document->summary_status_type_id === '1' ? 'accepted_in_cdr' : 'voided_in_cdr';
                $update_voided_column = ($this->type === 'summary') ? 'voided_summary_id' : 'voided_id';

                foreach ($this->document->documents as $doc) {

                    $update_data = [$update_column => 1];

                    //si es proceso de anulacion
                    if ($update_column === 'voided_in_cdr') {
                        $update_data[$update_voided_column] = $this->document->id;
                    }
                    $doc->document->update($update_data);
                }


                if ($this->type === 'summary') {
                    if ($this->document->summary_status_type_id === '1') {
                        $this->updateStateDocuments(self::ACCEPTED);
                    } else {
                        $this->updateStateDocuments(self::VOIDED);
                    }
                } else {
                    $this->updateStateDocuments(self::VOIDED);
                }
            }


            //2282 - Existe documento ya informado anteriormente - Detalle: value='ticket: 666, error: Comprobante: [[03-BA01-293], [03-BA01-294], [03-BA01-295]]',
            // ESTE ERROR SE GENERA CUANDO EN DICHO RESUMEN HAY BOLETAS QUE YA ESTAN ENVIADAS
            //Y EL RESTO DE BOLETAS QUE NO ESTAN REALMENTE EN SUNAT DEL MISMO RESUMEN QUEDAN VARADAS Y NO SE ENVIAN
            //LA SOLUCION ES CREAR OTRO RESUMEN QUITANDO LAS BOLETAS YA ENVIADAS.
            if( $cdrResponse->getCode() == 2282 ){

                //establecer al resumen defectuoso como rechazado
                $this->updateState(self::REJECTED);

                $observed_documents = '';

                //Buscar la posición del primer "[" en la cadena
                $initial_position = strpos( $cdrResponse->getDescription() , "[");

                if ($initial_position !== false) {

                    //Extraer el texto después del "[" hasta el final de la cadena
                    $observed_documents = substr( $cdrResponse->getDescription() , $initial_position + 1);


                    //1)Quitar comilla simple al final del texto, quitar corchetes, y finalmente crear un array delimitado por comas
                    $observed_documents = explode(", ",  str_replace(["'","[","]"], ["","",""], $observed_documents) );
                    $observed_documents = collect($observed_documents);

                    foreach ( $this->document->documents as $doc ) {

                        //Si el comprobante a verificar(boleta que corresponde al resumen) existe en el array de comprobantes(que estan en el error del cdr) ya enviados
                        //no hacer nada. Y si no existe ponerlo como registrado
                        $observed_document = $observed_documents->contains(function ($row, $key) use ($doc) {

                            $document_parts = explode('-',$row);
                            $document_type_id = $document_parts[0];
                            $series = $document_parts[1];
                            $number = $document_parts[2];

                            //registro de la tabla documents
                            $document = $doc->document;

                            $true = $document_type_id == $document->document_type_id &&
                            $series == $document->series &&
                            $number == $document->number;

                            return $true;
                        });
                        if( !$observed_document ){
                            $doc->document->update(['state_type_id'=>self::REGISTERED]);
                        }
                    }

                }
                $success = false;
                //se quito excepcion porque no guardaba los datos en la bd
                //throw new Exception("Code: {$cdrResponse->getCode()}; Description: {$cdrResponse->getDescription()}");
            }


            $this->response = [
                'success' => $success,
                'code' => $cdrResponse->getCode(),
                'description' => $cdrResponse->getDescription(),
                'notes' => $cdrResponse->getNotes()
            ];
        }
    }

    public function consultCdr()
    {

        $cdrXmlContent = $this->getXmlFromCdr($this->document->filename);
        if( $cdrXmlContent ){
            $this->document->has_cdr = 1;
            $this->document->save();
            $code = $cdrXmlContent['code'];
            $description = $cdrXmlContent['description'];
            $this->response = [
                'sent' => true,
                'code' => $code,
                'description' => $description,
                'notes' => []
            ];
            return;
        }


        $ws = new WsClient(SunatEndpoints::FE_CONSULTA_CDR.'?wsdl');
        $this->setSoapCredentials();
        $ws->setCredentials($this->soapUsername, $this->soapPassword);


        $consultCdrService = new ConsultCdrService();
        $consultCdrService->setClient($ws);
        $consultCdrService->setCodeProvider(new XmlErrorCodeProvider());
        $res = $consultCdrService->getStatusCdr(
            $this->company->number,
            $this->document->document_type_id,
            $this->document->series,
            $this->document->number
        );

        if (!$res->isSuccess()) {
            throw new Exception("Code: {$res->getError()->getCode()}; Description: {$res->getError()->getMessage()}");
        } else {
            $cdrResponse = $res->getCdrResponse();
            $this->uploadFile($res->getCdrZip(), 'cdr');
            //$this->updateState(self::ACCEPTED);
            $this->response = [
                'sent' => true,
                'code' => $cdrResponse->getCode(),
                'description' => $cdrResponse->getDescription(),
                'notes' => $cdrResponse->getNotes()
            ];
        }
    }

    public function uploadFile($file_content, $file_type)
    {
        $this->uploadStorage($this->document->filename, $file_content, $file_type);
    }

    private function setDataSoapType()
    {
        // $this->setSoapCredentials();
        // dd($this->soapUsername, $this->soapPassword, $this->endpoint);
        // $this->wsClient->setCredentials($this->soapUsername, $this->soapPassword);
        // $this->wsClient->setService($this->endpoint);

    }

    private function setPathCertificate()
    {
        if ($this->isDemo) {
            $this->pathCertificate = app_path('CoreFacturalo' . DIRECTORY_SEPARATOR .
                'WS' . DIRECTORY_SEPARATOR .
                'Signed' . DIRECTORY_SEPARATOR .
                'Resources' . DIRECTORY_SEPARATOR .
                'certificate.pem');
        } else {
            $this->pathCertificate = storage_path('app' . DIRECTORY_SEPARATOR .
                'certificates' . DIRECTORY_SEPARATOR . $this->company->certificate);
        }
    }

    private function setSoapCredentials()
    {
        // $this->soapUsername = ($this->isDemo) ? $this->company->number . 'MODDATOS' : $this->company->soap_username;
        // $this->soapPassword = ($this->isDemo) ? 'moddatos' : $this->company->soap_password;

        // if ($this->isOse) {

        //     if ($this->isDemo) {
        //         $this->endpoint = config('configuration.ose_demo');
        //     } else {
        //         $this->endpoint = config('configuration.ose_production');
        //     }
        // } else {
        //     switch ($this->type) {
        //         case 'retention':
        //             $this->endpoint = ($this->isDemo) ? SunatEndpoints::RETENCION_BETA : SunatEndpoints::RETENCION_PRODUCCION;
        //             break;
        //         case 'dispatch':
        //             $this->endpoint = ($this->isDemo) ? SunatEndpoints::GUIA_BETA : SunatEndpoints::GUIA_PRODUCCION;
        //             break;
        //         default:
        //             $this->endpoint = ($this->isDemo) ? SunatEndpoints::FE_BETA : SunatEndpoints::FE_PRODUCCION;
        //             break;
        //     }
        // }
    }
}
