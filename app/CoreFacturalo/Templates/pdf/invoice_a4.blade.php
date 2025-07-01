@php
function quitarTildes($texto) {
    $acentos = array(
        'á' => 'a',
        'é' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ú' => 'u',
        'Á' => 'A',
        'É' => 'E',
        'Í' => 'I',
        'Ó' => 'O',
        'Ú' => 'U'
    );
    return strtr($texto, $acentos);
}

$establishment = $document->establishment;
$customer = $document->customer;
$invoice = $document->invoice;

if($document->document_type_id == "07"){
//es nota de credito
$document->invoice = $document;
$document->invoice->document_id = $document->id;
}



$path_style =
app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
$document_number = $document->series.'-'.str_pad($document->number, 8, '0', STR_PAD_LEFT);


$establishment2 = \App\Models\Establishment::find($document->establishment_id);
$customer2 = \App\Models\Cliente::find($document->customer_id);
$configuration = \App\Models\Configuration::first();
$print_configuration = \App\Models\PrintConfiguration::first();
$document_configuration = \App\Models\DocumentConfiguration::first();

$payments = \App\Models\Payment::where('document_id',$document->invoice->document_id)->orderBy('created_at',
'ASC')->get();

$totalPayment = \App\Models\Payment::selectRaw("sum(total) as total")->where('document_id',$document->invoice->document_id)->first();

if($document->document_type_id == "07"){
$notes_credito = \App\Models\Note::where("document_id", $document->id)->first();
$document_data = \App\Models\Document::where('id',$notes_credito->affected_document_id)->first();
$document_number_reference = $document_data->series.'-'.str_pad($document_data->number, 8, '0', STR_PAD_LEFT);
}

$status_voucher = "CREDITO";
$date_now = explode(" ",$document->date_of_issue)[0];
$count_total = 0;
$end_pay = null;

if($document->is_credit==0){
    $status_voucher = "CONTADO";
}

if($payments!=null){
    $isCredit = false;
    foreach($payments as $value){
         $status_voucher = "CREDITO";
       if($value->date_of_issue == $date_now){
           if($totalPayment->total == $document->total){
                 $status_voucher = "CONTADO";
           }
        }
    }
}

$placeholderUnitTypeIds = [
    'FOT' => 'FOT (Pies)'
];

$SHOW_ITEM_DISCOUNT_ON_DISCOUNT_COLUMN = env('SHOW_ITEM_DISCOUNT_ON_DISCOUNT_COLUMN',false);


$labelPaymentDate = "pago";
//si esta con el ruc de yaqha que diga vencimiento, pedido de vanessa
if( $company->number == '20606475455' ) $labelPaymentDate = "vencimiento";

@endphp

<html>

<head>
    <title>{{ $document_number }}</title>
    <link href="{{ $path_style }}" rel="stylesheet" />
    <style>
        html {
            font-family: sans-serif;
        }

    </style>
</head>

<body>

    <table class="full-width">
        <tr>
            @if ($company->logo)
                <td width="20%">
                    <div class="company_logo_box">
                        <img src="{{ asset('storage/uploads/logos/' . $company->logo) }}" alt="{{ $company->name }}"
                            class="company_logo" style="max-width: 150px;">
                    </div>
                </td>
            @else
                <td width="20%">
                    <img src="{{ asset('logo/logo.jpg') }}" class="company_logo" style="max-width: 150px">
                </td>
            @endif
            <td width="45%" class="pl-3">
                <div class="text-left">

                    <h3 class="text-center">{{ $company->trade_name }}</h3>

                    <h5 class="">
                        @if($print_configuration->show_by_company_text)
                        DE:
                        @endif
                        {{ $company->name }}
                    </h5>


                    <h5>{{ $establishment2->description }}</h5>
                    <h6>{{ 'COD:' . strtoupper($establishment2->getAddressFullAttribute2()) }}</h6>
                    <h6>{{  strtoupper( quitarTildes( $establishment2->getAddressFullAttribute3() ) ) }}</h6>
                    <h6>{{ $establishment2->telephone !== '-' ? $establishment2->telephone : '' }}</h6>
                    <h6>{{ $establishment2->email !== '-' ? $establishment2->email : '' }}</h6>
                </div>
            </td>
            <td width="35%" class="border-box py-4 px-1 text-center">
                <h3 class="text-center">{{ 'R.U.C. N° ' . $company->number }}</h3>
                <h4 class="text-center">{{ $document->document_type->description }}</h4>
                <h3 class="text-center"><strong>N° {{ $document_number }}</strong></h3>
            </td>

            <td width="20%" class="border-box py-4 px-1 text-center">
                <h4 class="text-center">Estado de comprobante</h4>
                <br>
                <h5 class="text-center"><strong> {{ $status_voucher }}</strong></h5>
            </td>
        </tr>
    </table><br>
    <div class="border-no-bottom py-2 px-1 pb-0">
        <table class="full-width mt-3 ">
            <tr>

                <td width="15%">Cliente:</td>
                <td width="45%">{{ $customer->name }}</td>
                <td width="25%">Fecha de emisión:</td>
                <td width="15%">{{ $document->date_of_issue->format('d/m/Y') }} {{ $document->time_of_issue }}</td>

            </tr>
            @if ($document->document_type_id == '07')
                <tr>

                    <td width="15%">Documento Afectado:</td>
                    <td width="45%">{{ $document_number_reference }}</td>




                </tr>
            @endif
            <tr>

                <td>{{ $customer->identity_document_type->description }}:</td>
                <td>{{ $customer->number }}</td>
                @if ($invoice)
                    @if ( $invoice->date_of_due )
                    <td>Fecha de vencimiento:</td>
                    <td>{{ $invoice->date_of_due->format('d/m/Y') }}</td>
                    @endif
                @endif
            </tr>
            @if ($customer->address !== '')
                <tr>
                    <td class="align-top">Dirección:</td>
                    <td colspan="2">{{ $customer2->getAddressFullAttribute() }}</td>
                </tr>
            @endif

            @php
            $show_external_seller = $document_configuration->show_external_seller;

            $user_sale_text = $show_external_seller ? 'Cajero' : 'Vendedor';
            @endphp

            @if ($document_configuration->seller)
                <tr>
                    <td class="align-top">{{ $user_sale_text }}:</td>
                    <td colspan="2">{{ $document->user->name }}</td>
                </tr>

                @if ($document->external_seller && $show_external_seller)
                <tr>
                    <td class="align-top">Vendedor:</td>
                    <td colspan="2">{{ $document->external_seller->name }}</td>
                </tr>
                @endif
            @endif
        </table>
    </div>
    <div class="border-no-top py-4 px-1">
        <table class="full-width mt-12 mb-10">
            <thead>
                <tr class="bg-grey">
                    <th class="border-top text-left py-1">ITEM</th>
                    <th class="border-top text-left py-1">COD.</th>
                    <th class="border-top text-left py-2">DESCRIPCIÓN</th>
                    {{-- <th class="border-top text-left py-2">INF. ADD</th>
                    --}}
                    <th class="border-top text-center py-1">CANT.</th>
                    <th class="border-top text-center py-2">U.M</th>
                    <th class="border-top text-center py-2">P.UNIT</th>
                    <th class="border-top text-center py-2">DSCTO.</th>
                    <th class="border-top text-right py-2">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1 @endphp
                @foreach ($document->items as $row)
                    <tr>
                        <td class="align-top">{{ $i }}</td>
                        <td class="align-top">{{ $row->item->internal_id }}</td>
                        <td class="text-left">
                            {!! $row->item->description !!}

                            @php
                                $selected_price_list_item = $row->item->selected_price_list_item ?? null;
                            @endphp
                            @if( $selected_price_list_item != null )
                            @if( isset( $selected_price_list_item->factor_cant ) )
                                <br>
                                {{ $selected_price_list_item->factor_cant }} {{ $selected_price_list_item->name }}
                            @endif
                            @endif


                            @if ($row->attributes)
                                @foreach ($row->attributes as $attr)
                                    <br />{!! $attr->description !!} : {{ $attr->value }}
                                @endforeach
                                <br />

                            @endif

                            @if( !$SHOW_ITEM_DISCOUNT_ON_DISCOUNT_COLUMN )
                            @if ($row->discounts)
                                @foreach ($row->discounts as $dtos)
                                    <br /><small>{{ $dtos->factor * 100 }}% {{ $dtos->description }}</small>
                                @endforeach
                                <br />

                            @endif
                            @endif

                            <br />

                            {!! $row->item_informacion !!}

                        </td>
                        @php
                        $decimal = 0;
                        @endphp
                        @if (strlen(stristr($row->quantity, '.00')) == 0)
                            @php
                            $decimal = 2;
                            @endphp
                        @endif

                        <td class="text-center align-top">{{ number_format($row->quantity, $decimal) }}</td>
                        <td class="text-center align-top">{{ $placeholderUnitTypeIds[$row->item->unit_type_id] ?? $row->item->unit_type_id }}</td>
                        <td class="text-center align-top">
                        {{--
                                @if(  !isset( $row->item->selected_price_list_item )  )
                                {{number_format($row->unit_price, $configuration->decimal)}}

                            @else
                                    @if( $row->item->selected_price_list_item == null )
                                        {{number_format( $row->unit_price , 2 )}}
                                    @else

                                        @if( isset( $row->item->original_price ) )

                                            @if( $row->item->original_price < $row->unit_price )
                                            {{ number_format( $row->unit_price , $configuration->decimal ) }}
                                            @else()
                                            {{ number_format($row->item->original_price, $configuration->decimal ) }}
                                            @endif

                                        @else
                                        {{ number_format($row->unit_price, $configuration->decimal) }}
                                        @endif

                                    @endif

                            @endif
                        --}}
                            {{number_format($row->unit_price, $configuration->decimal)}}
                        </td>
                        <td class="text-center align-top">

                            @if ( $SHOW_ITEM_DISCOUNT_ON_DISCOUNT_COLUMN )

                                @if ($row->discounts)
                                    {{--
                                    @php
                                    $total_discount_line = 0;
                                    foreach ($row->discounts as $disto) {
                                    $total_discount_line += $disto->amount;
                                    }
                                    @endphp
                                    {{ number_format($total_discount_line, 2) }}%

                                    --}}

                                    @foreach ($row->discounts as $dtos)
                                        @if( count((array)$row->discounts) > 1 )
                                        <br />
                                        @endif
                                        {{ $dtos->factor * 100 }}% {{ $dtos->description }}
                                    @endforeach

                                @else
                                    0.00
                                @endif

                            @else

                                0.00

                                {{--
                                @if(  !isset( $row->item->selected_price_list_item )  )
                                    {{'0.00'}}
                                @else

                                    @if( $row->item->selected_price_list_item == null )
                                        {{'0.00'}}
                                    @else

                                        @if( isset( $row->item->original_price ) )

                                            @if( $row->item->original_price < $row->unit_price )
                                            {{'0.00'}}
                                            @else
                                            {{ number_format(
                                                ( $row->quantity * $row->item->original_price - $row->total )
                                                ,$configuration->decimal
                                            ) }}
                                            @endif

                                        @else
                                        {{ '0.00' }}
                                        @endif

                                    @endif

                                @endif
                                --}}


                            @endif



                            {{--@if ($row->discounts)
                                @php
                                $total_discount_line = 0;
                                foreach ($row->discounts as $disto) {
                                $total_discount_line = $total_discount_line + $disto->amount;
                                }
                                @endphp
                                {{ number_format($total_discount_line, 2) }}
                            @else
                                0
                            @endif --}}
                        </td>
                        <td class="text-right align-top">{{ number_format($row->total, 2) }}</td>
                    </tr>
                    @php $i++ @endphp
                @endforeach
            </tbody>
        </table>
        <table class="full-width mt-3">
            @if ($document->purchase_order)
                <tr>
                    <td width="25%"><strong>Orden de Compra:</strong> </td>
                    <td class="text-left">{{ $document->purchase_order }}</td>
                </tr>
            @endif
            @if ($document->guides)
                @foreach ($document->guides as $guide)
                    <tr>
                        <td>{{ $guide->document_type_id }}</td>
                        <td>{{ $guide->number }}</td>
                    </tr>
                @endforeach
            @endif
        </table>
        <table>
            <tr>
                @if (isset($document->additional_information))
            <tr>
                <td colspan="2"><b>Observaciones:</td>
                <td colspan="5">{!! nl2br(e($document->additional_information[0])) !!}</td>
            </tr>
            @endif
            </tr>
        </table>
    </div>
    <br>
    <div class="py-2 px-1">

        @if( $document->cuotas )
        <span class="font-bold">Cuotas de crédito</span>

        <table class="border-box" width="100%">
            <tr>
                <th class="border-box">Monto</th>
                <th class="border-box">Fecha de {{ $labelPaymentDate }}</th>
            </tr>

            @foreach ($document->cuotas as $cuota)
            <tr>
                <td class="border-right text-center">{{ number_format( $cuota->amount , $configuration->decimal ) }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime( $cuota->date_of_due )) }}</td>
            </tr>
            @endforeach

        </table>
        <div class="py-4"></div>
        @endif


        <table class="full-width">
            <tr>
                <td class="text-center" width="40%">
                    @foreach ($document->legends as $row)
                        <p>Son: <span class="font-bold">{{ $row->value }}
                                {{ $document->currency_type->description }}</span></p>
                    @endforeach
                </td>

                @if (env('LEGEND_MODE'))
            <tr>
                <td class="text-center desc"><span class="font-bold"><br></span></td>
            </tr>
            <tr>
                @if (env('LEGEND_MODE') == 1)

                    <td class="text-center desc"><span class="font-bold">BIENES TRANSFERIDOS EN LA AMAZONÍA REGIÓN SELVA
                            PARA SER CONSUMIDOS EN LA MISMA</span></td>
                @endif
                @if (env('LEGEND_MODE') == 2)
                    <td class="text-center desc"><span class="font-bold">SERVICIOS PRESTADOS EN LA AMAZONÍA REGIÓN SELVA
                            PARA SER CONSUMIDOS EN LA MISMA</span></td>
                @endif
            </tr>


            @if (env('LEGEND_MODE') == 3)
            <tr>
                <td class="text-center desc"><span class="font-bold">BIENES TRANSFERIDOS EN LA AMAZONÍA REGIÓN SELVA
                PARA SER CONSUMIDOS EN LA MISMA</span>
                </td>
            </tr>
            <tr>
                <td class="text-center desc"><span class="font-bold">SERVICIOS PRESTADOS EN LA AMAZONÍA REGIÓN SELVA
                        PARA SER CONSUMIDOS EN LA MISMA</span>
                </td>
            </tr>
            @endif

            @endif

            <td rowspan="2" width="60%" class="text-right">
                <table>
                    <tbody>
                        @if ($document->total_exportation > 0)
                            <tr>
                                <td colspan="5" class="text-right font-bold">OP. EXPORTACIÓN:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="text-right font-bold">{{ number_format($document->total_exportation, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($document->total_free > 0)
                            <tr>
                                <td colspan="5" class="text-right font-bold">OP. GRATUITAS:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="text-right font-bold">{{ number_format($document->total_free, 2) }}</td>
                            </tr>
                        @endif
                        @if ($document->total_unaffected > 0)
                            <tr>
                                <td colspan="5" class="text-right font-bold">OP. INAFECTAS:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="text-right font-bold">{{ number_format($document->total_unaffected, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($document->total_exonerated > 0)
                            <tr>
                                <td colspan="5" class="text-right font-bold">OP. EXONERADAS:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="text-right font-bold">{{ number_format($document->total_exonerated, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($document->total_taxed > 0)
                            <tr>
                                <td colspan="5" class="text-right font-bold">OP. GRAVADAS:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="text-right font-bold">{{ number_format($document->total_taxed, 2) }}</td>
                            </tr>
                        @endif
                        @if ($document->total_discount > 0)
                            <tr>
                                <td colspan="5" class="text-right font-bold">DESCUENTO TOTAL:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="text-right font-bold">{{ number_format($document->total_discount, 2) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="5" class="text-right font-bold">IGV: {{ $document->currency_type->symbol }}
                            </td>
                            <td class="text-right font-bold">{{ number_format($document->total_igv, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right font-bold">I.C.B.P.E.R.:
                                {{ $document->currency_type->symbol }}
                            </td>
                            <td class="text-right font-bold">{{ number_format($document->total_plastic_bag_taxes, 2) }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="5" class="text-right font-bold">TOTAL PAGADO:
                                {{ $document->currency_type->symbol }}
                            </td>
                            <td class="text-right font-bold">{{ number_format($document->total_paid, 2) }}</td>
                        </tr>

                        <tr>
                            <td colspan="5" class="text-right font-bold">TOTAL A PAGAR:
                                {{ $document->currency_type->symbol }}
                            </td>
                            <td class="text-right font-bold">{{ number_format($document->total, 2) }}</td>
                        </tr>

                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </td>
            </tr>
            <tr>
                <td class="text-center" width="40%">
                    <div class="text-center"><img class="qr_code" src="data:image/png;base64, {{ $document->qr }}" />
                    </div>
                    <br>
                    <p>Código Hash: {{ $document->hash }}</p>
                </td>
            </tr>

            @if ($establishment2->establishment_description != '-')
                <tr>
                    <td class="text-center desc">
                        <p><strong>Detalle de establecimiento: </strong></p>
                        <p>{{ $establishment2->establishment_description }}</p>
                    </td>

                </tr>
            @endif

            <br>
            <tr>

                <td class="text-center desc"><strong>Todos los derechos reservados {{ date('Y') }} </strong></td>
            </tr>
        </table>


    </div>
</body>

</html>
