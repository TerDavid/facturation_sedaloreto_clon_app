<?php

namespace App\CoreFacturalo\Requests\Inputs;

use App\CoreFacturalo\Requests\Inputs\Common\ActionInput;
use App\CoreFacturalo\Requests\Inputs\Common\EstablishmentInput;
use App\CoreFacturalo\Requests\Inputs\Common\LegendInput;
use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;
use App\Models\Cliente;
use App\Models\Company;
use App\Models\Document;
use App\Models\Item;
use Illuminate\Support\Str;

class DocumentInput
{
    public static function set($inputs)
    {
        // dd($inputs);
        $document_type_id = $inputs['document_type_id'];
        // if($document_type_id=="07"){
        //     $document_type_id = "17";
        // }
        // dd($document_type_id);
        $series = $inputs['series'];
        $number = $inputs['number'];

        $company = Company::active();
        $soap_type_id = $company->soap_type_id;
        $number = Functions::newNumber($soap_type_id, $document_type_id, $series, $number, Document::class);

        Functions::validateUniqueDocument($soap_type_id, $document_type_id, $series, $number, Document::class);

        $filename = Functions::filename($company, $document_type_id, $series, $number);
        $establishment = EstablishmentInput::set($inputs['establishment_id']);
        $customer = PersonInput::set($inputs['customer_id']);

        if (in_array($document_type_id, ['01', '03'])) {
            $array_partial = self::invoice($inputs);
            $invoice = $array_partial['invoice'];
            $note = null;
        } else {
            $array_partial = self::note($inputs);
            $note = $array_partial['note'];
            $invoice = null;
        }

        $inputs['type'] = $array_partial['type'];
        $inputs['group_id'] = $array_partial['group_id'];

        if (isset($inputs['quotation_id'])) {
            $quotation_id =  $inputs['quotation_id'];
        } else {
            //$quotation_id = false;
            $quotation_id = null;
        }

        if (isset($inputs['additional_information'])) {
            $additional_information =  $inputs['additional_information'];
        } else {
            $additional_information =  "";
        }


        return [
            'type' => $inputs['type'],
            'group_id' => $inputs['group_id'],
            'user_id' => auth()->id(),
            'external_seller_id' => Functions::valueKeyInArray($inputs, 'external_seller_id'),
            'external_id' => Str::uuid()->toString(),
            'establishment_id' => $inputs['establishment_id'],
            'establishment' => $establishment,
            'quotation_id' => $quotation_id,
            'soap_type_id' => $soap_type_id,
            'state_type_id' => '01',
            'status_paid' => Functions::valueKeyInArray($inputs, 'status_paid', 1),
            'is_credit' => (($inputs['status_paid'] ?? 1) == 1) ? 0 : 1, /*$inputs['is_credit'] ?? 0*/
            'ubl_version' => '2.1',
            'filename' => $filename,
            'document_type_id' => $document_type_id,
            'series' => $series,
            'number' => $number,
            'date_of_issue' => $inputs['date_of_issue'],
            'time_of_issue' => $inputs['time_of_issue'],
            'customer_id' => $inputs['customer_id'],
            'customer' => $customer,
            'currency_type_id' => $inputs['currency_type_id'],
            'purchase_order' => $inputs['purchase_order'] ?? null,
            'exchange_rate_sale' => $inputs['exchange_rate_sale'],
            'total_prepayment' => Functions::valueKeyInArray($inputs, 'total_prepayment', 0),
            'total_discount' => Functions::valueKeyInArray($inputs, 'total_discount', 0),
            'total_charge' => Functions::valueKeyInArray($inputs, 'total_charge', 0),
            'total_exportation' => Functions::valueKeyInArray($inputs, 'total_exportation', 0),
            'total_free' => Functions::valueKeyInArray($inputs, 'total_free', 0),
            'total_taxed' => $inputs['total_taxed'],
            'total_unaffected' => $inputs['total_unaffected'],
            'total_exonerated' => $inputs['total_exonerated'],
            'total_igv' => $inputs['total_igv'],
            'total_base_isc' => Functions::valueKeyInArray($inputs, 'total_base_isc', 0),
            'total_isc' => Functions::valueKeyInArray($inputs, 'total_isc', 0),
            'total_base_other_taxes' => Functions::valueKeyInArray($inputs, 'total_base_other_taxes', 0),
            'total_other_taxes' => Functions::valueKeyInArray($inputs, 'total_other_taxes', 0),
            'total_plastic_bag_taxes' => Functions::valueKeyInArray($inputs, 'total_icbper', 0),
            'total_taxes' => $inputs['total_taxes'],
            'total_value' => $inputs['total_value'],
            'total' => $inputs['total'],
            'total_paid' => 0,
            'items' => self::items($inputs),
            'charges' => self::charges($inputs),
            'discounts' => self::discounts($inputs),
            'prepayments' => self::prepayments($inputs),
            'guides' => self::guides($inputs),
            'related' => self::related($inputs),
            'perception' => self::perception($inputs),
            'detraction' => self::detraction($inputs),
            'invoice' => $invoice,
            'note' => $note,
            'additional_information' => $additional_information,
            'legends' => LegendInput::set($inputs),
            'actions' => ActionInput::set($inputs),
            'operations_campos_items_ids' => $inputs["operations_campos_items_ids"] ?? [],
            'cuotas' => self::cuotas($inputs),
            'payments' => Functions::valueKeyInArray($inputs, 'payments', []),
        ];
    }

    private static function cuotas($inputs)
    {
        //finalidad
        //Generar 2 decimales al monto.
        //Generar los "Description" con 'Cuota001',Cuota002....


        if ($inputs['document_type_id'] != '01') return null;
        if ($inputs['date_of_due'] == null) return null;


        if (array_key_exists('cuotas', $inputs)) {
            if ($inputs['cuotas']) {

                //se hace esta validacion porue la api retorna un jsonplano
                if (!is_array($inputs['cuotas'])) {
                    $inputs['cuotas'] = (array)json_decode($inputs['cuotas'], true);
                }

                $nombreCuota = "Cuota";

                foreach ($inputs['cuotas'] as $key => $row) {

                    $amount = $inputs['cuotas'][$key]["amount"];

                    $number = ($key + 1);
                    $description = $nombreCuota . str_pad($number, 3, '0', STR_PAD_LEFT);
                    $inputs['cuotas'][$key]["description"] = $description;
                    $inputs['cuotas'][$key]["amount"] = round($amount, 2);
                }
                return $inputs['cuotas'];
            }
        }
        return null;
    }

    private static function formatAdicionales($item)
    {

        if (!isset($item['adicionales_seleccionados'])) {
            return null;
        }

        $grupoAdicionales = [];

        foreach ($item['adicionales_seleccionados']  as $key => $row) {

            $grupo = [
                //éste es el id de la compra
                'operation_campo_item_id' => $row['operation_campo_item_id'],

                //éste es el id de la venta
                //este servirá en la parte de anulación por individual NC/ND
                //hace referencía al id del 'operations_campos_items' de la venta.
                //viene el id siempre y cuando sea nota de crédito
                'sale_operation_campo_item_id' => $row['sale_operation_campo_item_id'],

                'adicionales' => $row['adicionales']
            ];

            array_push($grupoAdicionales, $grupo);
        }

        return $grupoAdicionales;
    }

    private static function items($inputs)
    {
        // dd($inputs);
        $isCreditNote = false;

        if ($inputs['document_type_id'] == '07' || $inputs['document_type_id'] == '08') {
            $isCreditNote = true;
        }
        $cliente = Cliente::find($inputs['customer_id']);
        $condition = $cliente->tarifa || $cliente->consumoSinMedidor;

        if (array_key_exists('items', $inputs) && $condition) {
            $items = [];
            $items_reference = [];

            //hacer un recorrido de los $inputs['items'] en caso se decida pagar m'as de una cuota
            if ($cliente->tarifa) {
                foreach ($inputs['items'] as $row) {

                    $pre_items = [
                        [
                            'item' => [

                                'item_code' => md5($cliente->tarifa->categoria . $cliente->tarifa->rango_min . $cliente->tarifa->rango_max . $cliente->tarifa->tarifa_agua),
                                'description' => 'SERVICIO ' . $cliente->tarifa->categoria . ' Tarifa Agua',
                                'sale_unit_price' => +$cliente->tarifa->tarifa_agua,
                            ],
                            'quantity' => $row['quantity'],
                            'total_base_igv' =>  round($cliente->tarifa->tarifa_agua * $row['quantity'], 2),
                        ],
                        [
                            'item' => [
                                'item_code' => md5($cliente->tarifa->categoria . $cliente->tarifa->rango_min . $cliente->tarifa->rango_max . $cliente->tarifa->tarifa_alcantarillado),
                                'description' => 'SERVICIO ' . $cliente->tarifa->categoria . ' Tarifa Alcantarillado',
                                'sale_unit_price' => +$cliente->tarifa->tarifa_alcantarillado
                            ],
                            'quantity' => 1,
                            'total_base_igv' => +$cliente->tarifa->tarifa_alcantarillado,
                        ],
                        [
                            'item' => [
                                'item_code' => md5($cliente->tarifa->categoria . $cliente->tarifa->rango_min . $cliente->tarifa->rango_max . $cliente->tarifa->cargo_fijo),
                                'description' => 'SERVICIO ' . $cliente->tarifa->categoria . ' Cargo Fijo',
                                'sale_unit_price' => +$cliente->tarifa->cargo_fijo,
                            ],
                            'quantity' => 1,
                            'total_base_igv' => +$cliente->tarifa->cargo_fijo,
                        ],
                    ];
                    $items_reference = array_merge($items_reference, $pre_items);
                }
                // dd($cliente->tarifa);
            } else if ($cliente->consumoSinMedidor) {
                // $code = md5($cliente->consumoSinMedidor->categoria.$cliente->consumoSinMedidor->rango_min.$cliente->consumoSinMedidor->rango_max.$cliente->consumoSinMedidor->tarifa_agua);
                // $code = md5($cliente->consumoSinMedidor->categoria.$cliente->consumoSinMedidor->rango_min.$cliente->consumoSinMedidor->rango_max.$cliente->consumoSinMedidor->tarifa_alcantarillado);
                // $code = md5($cliente->consumoSinMedidor->categoria.$cliente->consumoSinMedidor->rango_min.$cliente->consumoSinMedidor->rango_max.$cliente->consumoSinMedidor->cargo_fijo);
                // dd($cliente->consumoSinMedidor);
            }
            $inputs['items'] = collect($items_reference)->map(function ($item) {
                $total_base_init = round($item['item']['sale_unit_price'] * $item['quantity'], 2);
                return [
                    'quantity' => $item['quantity'],
                    'price_type_id' => '01',
                    'unit_price' => $item['item']['sale_unit_price'],
                    'affectation_igv_type_id' => '20',
                    'total_base_igv' => $total_base_init,
                    'total_value' => $total_base_init,
                    'total' => $total_base_init,
                    'percentage_igv' => 18,
                    'total_igv' => 0,
                    'system_isc_type_id' => null,
                    'total_taxes' => 0,
                    'item' => [
                        ...$item['item'],
                        'currency_type_id' => 'PEN',
                        'unit_type_id' => 'NIU',
                        'item_type_id' => '02',
                        'amount_plastic_bag_taxes' => 0,
                        'sale_affectation_igv_type_id' => 20,
                        'purchase_affectation_igv_type_id' => 20,
                    ],
                ];
            });
            // dd($inputs['items']);
            foreach ($inputs['items'] as $row) {
                // dd($row);
                $use_variations = $row['item']['use_variations'] ?? false;

                // $item = Item::find($row['item_id']);
                $item = Item::where('item_code', $row['item']['item_code'])->first();
                if (!$item) {
                    // dd('create');
                    $item = Item::create($row['item']);
                }
                // buscar el item base a cierto parametros

                // $code = $row['item']['item_code'] ?? null;
                //tarifa

                // dd($item);
                // identificar el tipo de consumo
                $items[] = [
                    'item_id' => $item->id,
                    'item' => [
                        'description' => ($isCreditNote) ? ($use_variations ? ($row['item']['original_description'] . self::generateItemDescriptionFromVariations($row)) : ($row['item']["description"] ?? $item->description)) : self::generateItemDescription($row, $item->description),
                        'original_description' => $item->description,
                        'item_type_id' => $item->item_type_id,

                        'currency_type_id' => $row["item"]["currency_type_id"] ?? $item->currency_type_id,
                        'sale_unit_price' => $row['item']['sale_unit_price'] ?? $item->currency_type_id,
                        'purchase_unit_price' => $row["item"]['purchase_unit_price'] ?? $item->purchase_unit_price,
                        'has_isc' => $row["item"]['has_isc'] ?? $item->has_isc,
                        'system_isc_type_id' => $row["item"]['system_isc_type_id'] ?? $item->system_isc_type_id,
                        'percentage_isc' => $row["item"]['percentage_isc'] ?? $item->percentage_isc,
                        'attributes' => $row["item"]['attributes'] ?? $item->attributes,
                        'unit_price' => $row['unit_value'] ?? $item->sale_unit_price,


                        'internal_id' => $item->internal_id,
                        'item_code' => $item->item_code,
                        'item_code_gs1' => $item->item_code_gs1,
                        'unit_type_id' => $item->unit_type_id,
                        'included_igv' => $item->included_igv,
                        'icbper' => $item->icbper,
                        'product_account_number_concar' => $item->product_account_number_concar,
                        'cost_center_code_concar' => $item->cost_center_code_concar,
                        'proyect_number_concar' => $item->proyect_number_concar,
                        'amount_plastic_bag_taxes' => $item->amount_plastic_bag_taxes,
                        'original_price' => $item->sale_unit_price,
                        'selected_price_list_item' => $row['selected_price_list_item'] ?? null,
                        'adicionales' => /*$isCreditNote ? null :*/ self::formatAdicionales($row),
                        'use_additional_information' => $row["item"]["use_additional_information"] ?? false,
                        'use_variations' => $use_variations
                    ],
                    'quantity' => $row['quantity'],
                    'unit_value' => $row['unit_value'] ?? 0,
                    'price_type_id' => $row['price_type_id'],
                    'unit_price' => $row['unit_price'],
                    'affectation_igv_type_id' => $row['affectation_igv_type_id'],
                    'total_base_igv' => $row['total_base_igv'],
                    'percentage_igv' => $row['percentage_igv'],
                    'total_igv' => $row['total_igv'],
                    'system_isc_type_id' => $row['system_isc_type_id'],
                    'total_base_isc' => Functions::valueKeyInArray($row, 'total_base_isc', 0),
                    'percentage_isc' => Functions::valueKeyInArray($row, 'percentage_isc', 0),
                    'total_isc' => Functions::valueKeyInArray($row, 'total_isc', 0),
                    'total_base_other_taxes' => Functions::valueKeyInArray($row, 'total_base_other_taxes', 0),
                    'percentage_other_taxes' => Functions::valueKeyInArray($row, 'percentage_other_taxes', 0),
                    'total_other_taxes' => Functions::valueKeyInArray($row, 'total_other_taxes', 0),
                    'total_taxes' => $row['total_taxes'],
                    'total_plastic_bag_taxes' => Functions::valueKeyInArray($row, 'total_plastic_bag_taxes', 0),
                    'total_value' => $row['total_value'],
                    'total_charge' => Functions::valueKeyInArray($row, 'total_charge', 0),
                    'total_discount' => Functions::valueKeyInArray($row, 'total_discount', 0),
                    'total' => $row['total'],
                    'attributes' => self::attributes($row),
                    'discounts' => self::discounts($row),
                    // 'item_informacion' => $row["item_informacion"],
                    'item_informacion' => isset($row["item_informacion"]) ? $row["item_informacion"] : null,
                    'charges' => self::charges($row),
                    'adicionales_seleccionados' => (($row["item"]["use_additional_information"] ?? false)) ? $row['adicionales_seleccionados'] : [],
                    'use_additional_information' => $row["item"]["use_additional_information"] ?? false,
                    'variation_stock' => $row['variation_stock'] ?? $row['variations'] ?? []
                ];
            }
            return $items;
        }
        return null;
    }

    private static function generateItemDescription($requestItem, $originalDescription)
    {

        $adicionales_seleccionados = $requestItem['adicionales_seleccionados'] ?? [];


        $str = '';

        foreach ($adicionales_seleccionados as $row) {
            foreach ($row['adicionales'] as $key2 => $row2) {
                if ($row2['show_on_invoice']) {
                    $str .= $row2['campo_name'] . ' = ' . $row2['valor'];

                    if (($key2 + 1) != count($row['adicionales'])) {
                        $str = $str . ' | ';
                    }
                }
            }
        }

        $adicionalesStr = (strlen($str) > 0) ? ": {$str}" : $str;

        //Output example
        // Color = Negro |Imei = 928 |Propietario = Gian
        $originalDescription .= $adicionalesStr;

        $originalDescription .= self::generateItemDescriptionFromVariations($requestItem, $adicionalesStr);


        return $originalDescription;
    }
    private static function generateItemDescriptionFromVariations($requestItem, $adicionalesStr = '')
    {

        $variation_stock = $requestItem['variation_stock'] ?? $requestItem['variations'] ?? [];

        $strVariations = '';
        foreach ($variation_stock as $key => $row) {

            if ($key == 0) {
                //si pasa por la primera iteracion entonces hay variaciones
                // si hay adicionales al final del texto poner ", ", si no lo hay poner ": "
                $strVariations .= ((strlen($adicionalesStr) > 0) ? ', ' : ': ');
            }

            $strVariations .= $row['quantity'] . ' - ';

            $values = $row['values'] ?? $row['variation_stock']['values'];

            foreach ($values as $key2 => $value) {
                $variation_name = $value['value']['variation']['name'];
                $variation_value = $value['value']['value'];

                $comma_separator = ($key2 + 1) < count($values) ? ', ' : '';

                $strVariations .= $variation_name . ': ' . $variation_value . $comma_separator;
            }
            $pleat_separator = ($key + 1) < count($variation_stock) ? ' | ' : '';
            $strVariations .= $pleat_separator;
        }

        //strVariations output example
        // 1 - Color: Rojo Talla: S Sexo: U | 2 - Color: Rojo Talla: M Sexo: U
        return $strVariations;
    }

    private static function attributes($inputs)
    {
        if (array_key_exists('attributes', $inputs)) {
            if ($inputs['attributes']) {
                $attributes = [];
                foreach ($inputs['attributes'] as $row) {
                    $attribute_type_id = $row['attribute_type_id'];
                    $description = $row['description'];
                    $value = array_key_exists('value', $row) ? $row['value'] : null;
                    $start_date = array_key_exists('start_date', $row) ? $row['start_date'] : null;
                    $end_date = array_key_exists('start_date', $row) ? $row['start_date'] : null;
                    $duration = array_key_exists('duration', $row) ? $row['duration'] : null;

                    $attributes[] = [
                        'attribute_type_id' => $attribute_type_id,
                        'description' => $description,
                        'value' => $value,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'duration' => $duration,
                    ];
                }
                return $attributes;
            }
        }
        return null;
    }

    private static function charges($inputs)
    {
        if (array_key_exists('charges', $inputs)) {
            if ($inputs['charges']) {
                $charges = [];
                foreach ($inputs['charges'] as $row) {
                    $charge_type_id = $row['charge_type_id'];
                    $description = $row['description'];
                    $factor = $row['factor'];
                    $amount = $row['amount'];
                    $base = $row['base'];

                    $charges[] = [
                        'charge_type_id' => $charge_type_id,
                        'description' => $description,
                        'factor' => $factor,
                        'amount' => $amount,
                        'base' => $base,
                    ];
                }
                return $charges;
            }
        }
        return null;
    }

    private static function discounts($inputs)
    {
        if (array_key_exists('discounts', $inputs)) {
            if ($inputs['discounts']) {
                $discounts = [];
                foreach ($inputs['discounts'] as $row) {
                    $discount_type_id = $row['discount_type_id'];
                    $description = $row['description'];
                    $factor = $row['factor'];
                    $amount = $row['amount'];
                    $base = $row['base'];

                    $discounts[] = [
                        'discount_type_id' => $discount_type_id,
                        'description' => $description,
                        'factor' => $factor,
                        'amount' => $amount,
                        'base' => $base,
                    ];
                }
                return $discounts;
            }
        }
        return null;
    }

    private static function prepayments($inputs)
    {
        if (array_key_exists('prepayments', $inputs)) {
            if ($inputs['prepayments']) {
                $prepayments = [];
                foreach ($inputs['prepayments'] as $row) {
                    $number = $row['number'];
                    $document_type_id = $row['document_type_id'];
                    $amount = $row['amount'];

                    $prepayments[] = [
                        'number' => $number,
                        'document_type_id' => $document_type_id,
                        'amount' => $amount
                    ];
                }
                return $prepayments;
            }
        }
        return null;
    }

    private static function guides($inputs)
    {
        if (array_key_exists('guides', $inputs)) {
            if ($inputs['guides']) {
                $guides = [];
                foreach ($inputs['guides'] as $row) {
                    $number = $row['number'];
                    $document_type_id = $row['document_type_id'];

                    $guides[] = [
                        'number' => $number,
                        'document_type_id' => $document_type_id,
                    ];
                }
                return $guides;
            }
        }
        return null;
    }

    private static function related($inputs)
    {
        if (array_key_exists('related', $inputs)) {
            if ($inputs['related']) {
                $related = [];
                foreach ($inputs['related'] as $row) {
                    $number = $row['number'];
                    $document_type_id = $row['document_type_id'];
                    $amount = $row['amount'];

                    $related[] = [
                        'number' => $number,
                        'document_type_id' => $document_type_id,
                        'amount' => $amount
                    ];
                }
                return $related;
            }
        }
        return null;
    }

    private static function perception($inputs)
    {
        if (array_key_exists('perception', $inputs)) {
            if ($inputs['perception']) {
                $perception = $inputs['perception'];
                $code = $perception['code'];
                $percentage = $perception['percentage'];
                $amount = $perception['amount'];
                $base = $perception['base'];

                return [
                    'code' => $code,
                    'percentage' => $percentage,
                    'amount' => $amount,
                    'base' => $base,
                ];
            }
        }
        return null;
    }

    private static function detraction($inputs)
    {
        if (array_key_exists('detraction', $inputs)) {
            if ($inputs['detraction']) {
                $detraction = $inputs['detraction'];
                $code = $detraction['code'];
                $percentage = $detraction['percentage'];
                $amount = $detraction['amount'];
                $payment_method_id = $detraction['payment_method_id'];
                $bank_account = $detraction['bank_account'];

                return [
                    'code' => $code,
                    'percentage' => $percentage,
                    'amount' => $amount,
                    'payment_method_id' => $payment_method_id,
                    'bank_account' => $bank_account,
                ];
            }
        }
        return null;
    }

    private static function invoice($inputs)
    {
        $operation_type_id = $inputs['operation_type_id'];
        $date_of_due = $inputs['date_of_due'];

        return [
            'type' => 'invoice',
            'group_id' => ($inputs['document_type_id'] === '01') ? '01' : '02',
            'invoice' => [
                'operation_type_id' => $operation_type_id,
                'date_of_due' => $date_of_due,
            ]
        ];
    }

    private static function note($inputs)
    {
        $document_type_id = $inputs['document_type_id'];
        $note_credit_or_debit_type_id = $inputs['note_credit_or_debit_type_id'];
        $note_description = $inputs['note_description'];
        $affected_document_id = $inputs['affected_document_id'];

        $affected_document = Document::find($affected_document_id);

        $type = ($document_type_id === '07') ? 'credit' : 'debit';

        return [
            'type' => $type,
            'group_id' => $affected_document->group_id,
            'note' => [
                'note_type' => $type,
                'note_credit_type_id' => ($type === 'credit') ? $note_credit_or_debit_type_id : null,
                'note_debit_type_id' => ($type === 'debit') ? $note_credit_or_debit_type_id : null,
                'note_description' => $note_description,
                'affected_document_id' => $affected_document->id
            ]
        ];
    }
}
