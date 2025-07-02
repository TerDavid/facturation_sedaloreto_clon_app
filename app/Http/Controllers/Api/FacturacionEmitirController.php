<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Catalogs\DocumentType;
use App\Models\Catalogs\UnitType;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Consumo;
use App\Models\Establishment;
use App\Models\Series;
use App\CoreFacturalo\Facturalo;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturacionEmitirController extends Controller
{
    public function __construct()
    {
        $this->middleware('input.request:document,web', ['only' => ['store']]);
    }

    public function index()
    {
        // $sectores = $ciudad->sectores2;
        $tipo_comprobante = DocumentType::where('active', 1)->get();
        $establecimiento = Establishment::first();
        $series = Series::where('establishment_id', $establecimiento->id)
            ->whereIn('document_type_id', $tipo_comprobante->pluck('id')->toArray())  
            ->get();
        $unit_type = UnitType::where('active', 1)->get();
        return response()->json(compact('tipo_comprobante', 'establecimiento', 'series', 'unit_type'));
    }

    public function getInformacionConsumoCliente(Request $request)
    {
        $cliente = Cliente::with('consumos', 'tarifa')->find($request->cliente);
        // $consumo = Consumo::where('cliente_id', $cliente->id)->get();
        return response()->json(compact('cliente'));
    }


    public function store(Request $request)
    {
        // $request->validate([
        //     'valor_recibido' => 'required|numeric|min:0',
        // ]);
        // return response()->json(['message' => 'Factura generada correctamente']);

        // $validarAdicionalesVendidos = OperationCampoItemController::validarAdicionalesVendidos( $request );
        // if( !$validarAdicionalesVendidos["success"] ) return $validarAdicionalesVendidos;


        $validTipDocUsuario = $this->validarTipoDocIdentidadUsuario( $request );
        if( !$validTipDocUsuario["success"] )return $validTipDocUsuario;

        // dd($request->all());
        // $pos = Pos::active();

        // if ($pos == null) {
        //     return [
        //         'success' => false,
        //         'message' => "!Necesita aperturar una caja!"
        //     ];
        // } else {

            try {
                $array = [$request];

                $fact = DB::transaction(function () use ($array) {
                    $request = $array[0];
                    // dd($request->establishment);
                    // $pos = $array[1];
                    $facturalo = new Facturalo();

                    // dd($request->all());
                    $facturalo->save($request->all());
                    $facturalo->createXmlUnsigned();
                    $facturalo->signXmlUnsigned();
                    $facturalo->updateHash();
                    $facturalo->updateQr();
                    $facturalo->createPdf();

                    // if ($request->input('quotation_id')) {
                    //     Quotation::where('id', $request->input('quotation_id'))->update(['state_type_id' => '05']);
                    // }

                    $document = $facturalo->getDocument();
                    // $pos_sales = new PosSales();
                    // $pos_sales->table_name = 'documents';
                    // $pos_sales->document_id = $document->id;
                    // $pos_sales->pos_id = $pos;

                    // $pos_sales->save();

                    return $facturalo;
                });

                $fact->senderXmlSignedBill();
                $document = $fact->getDocument();
                $response = $fact->getResponse();
                //$this->print_document_to_ticket($document->id);




                /*Si es nota de credito o debito que no se creen sus operation
                porque no se estan vendiendo
                */
                // if( $request->type == 'invoice' ){
                //     $operationCampoItemController = new OperationCampoItemController();
                //     /*registrar adicionales*/

                //     foreach ( $request->input('items') as $row) {

                //         /*adicionales*/
                //         foreach ( $fact->getInsertedItems()  as $docItem) {
                //             $operationCampoItemController->registrarOperationsCamposItems(
                //                 'document_sale',
                //                 $row["adicionales_seleccionados"],
                //                 $docItem->id,
                //                 $request->all()
                //             );
                //         }
                //         /*adicionales*/

                //         /*varaciones*/
                //         foreach ($row['variation_stock'] as $row_variation_stock) {
                //             $variation_stock_id = $row_variation_stock['variation_stock_id'] ?? $row_variation_stock['id']??null;
                //             $variation_stock = ItemWarehouseVariationStock::find($variation_stock_id);
                //             $variation_stock->stock -= $row_variation_stock['quantity'];
                //             $variation_stock->save();
                //         }
                //         /*variaciones*/

                //     }

                // }



                //devuelve un id de la tabla documents
                //$find_duplicated_document = $this->find_duplicated_document($document->id);
                //'id' => ( $find_duplicated_document["replaced"] == null ) ? $document->id : $find_duplicated_document["replaced"]

                return [
                    'success' => true,
                    'data' => [
                        'id' => $document->id
                    ]
                ];

            } catch (Exception $ex) {
                throw $ex;
                
                if ($ex->getMessage() == "Code: HTTP; Description: Could not connect to host") {
                    //en lugar de que salga el mensaje que no se pudo enviar a sunat, que se genere normal y pueda imprimir
                    //como si no pasara nada internamente
                    return [
                        'success' => true,
                        'data' => [
                            'id' => $fact->getDocument()->id
                        ]
                        //'success' => false,
                        //'message' =>  "El comprobante se generó pero no pudo enviarse a SUNAT por una falla de internet, diríjase a listados para verificarlo"
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' =>  $ex->getMessage(),
                        'trace' =>  $ex->getTraceAsString(),
                        'file' =>  $ex->getFile(),
                        'line' =>  $ex->getLine()
                    ];
                }
            }
        // }
    }

    public function validarTipoDocIdentidadUsuario( $request ){
        $person =  Cliente::where('id', $request->customer_id)->get()[0];
        if (!$person->id) {
            return [
                'success' => false,
                'message' => "No se puede realizar comprobante con un cliente no registrado"
            ];
        }
        // if ($person->identity_document_type_id == "1" && $request->document_type_id == "01") {
        //     return [
        //         'success' => false,
        //         'message' => "No se puede realizar una factura con un número de DNI"
        //     ];
        // } else if ($person->identity_document_type_id == "6" && $request->document_type_id == "03") {
        //     return [
        //         'success' => false,
        //         'message' => "No se puede realizar una boleta con un número de RUC"
        //     ];
        // }
        return ["success" => true];
    }
}
