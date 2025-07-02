<?php

namespace App\CoreFacturalo\Requests\Inputs;

use App\Models\Document;
use App\Models\DocumentConfiguration;
use Carbon\Carbon;
use Exception;
use stdClass;

class Functions
{
    public static function newNumber($soap_type_id, $document_type_id, $series, $number, $model)
    {
        if ($number === '#') {
            $document = $model::select('number')
                ->where('soap_type_id', $soap_type_id)
                ->where('document_type_id', $document_type_id)
                ->where('series', $series)
                ->orderBy('number', 'desc')
                ->first();
            return ($document) ? (int)$document->number + 1 : 1;
        }
        return $number;
    }

    public static function newNumber2($document_type_id, $series, $number, $model)
    {
        if ($number === '#') {
            $document = $model::select('number')
                ->where('document_type_id', $document_type_id)
                ->where('series', $series)
                ->orderBy('number', 'desc')
                ->first();
            return ($document) ? (int)$document->number + 1 : 1;
        }
        return $number;
    }

    public static function filename($company, $document_type_id, $series, $number)
    {
        return join('-', [$company->number, $document_type_id, $series, $number]);
    }

    public static function validateUniqueDocument($soap_type_id, $document_type_id, $series, $number, $model)
    {
        $document = $model::where('soap_type_id', $soap_type_id)
            ->where('document_type_id', $document_type_id)
            ->where('series', $series)
            ->where('number', $number)
            ->first();
        if ($document) {
            $ex = new Exception("El documento: {$document_type_id} {$series}-{$number} ya se encuentra registrado.");
            $ex->data = [
                'external_id' => $document->external_id,
                'state_type' => $document->state_type,
                'accepted_in_cdr' => (bool)$document->accepted_in_cdr,
                'voided_in_cdr' => (bool)$document->voided_in_cdr
            ];
            throw $ex;
        }
    }

    public static function validateUniqueDocument2($document_type_id, $series, $number, $model)
    {
        $document = $model::where('document_type_id', $document_type_id)
            ->where('series', $series)
            ->where('number', $number)
            ->first();
        if ($document) {
            throw new Exception("El documento: {$document_type_id} {$series}-{$number} ya se encuentra registrado.");
        }
    }
    //añadi un comentario
    public static function identifier($soap_type_id, $date_of_issue, $model)
    {
        // $document_configuration = DocumentConfiguration::first();
        $document_configuration = new stdClass();
        $document_configuration->id = 1;
        $document_configuration->seller = 0;
        $document_configuration->show_external_seller = 0;
        $document_configuration->show_logo_in_pdf = 0;
        $document_configuration->document_sucursal = 1;
        $documents = $model::where('soap_type_id', $soap_type_id)
            ->where('date_of_issue', $date_of_issue)
            ->get();
        //$numeration = count($documents) + env('DOCUMENT_SUCURSAL');
        $numeration = count($documents) + $document_configuration->document_sucursal;
        $path = explode('\\', $model);
        switch (array_pop($path)) {
            case 'Voided':
                $prefix = 'RA';
                break;
            default:
                $prefix = 'RC';
                break;
        }

        return join('-', [$prefix, Carbon::parse($date_of_issue)->format('Ymd'), $numeration]);
    }

    public static function valueKeyInArray($inputs, $key, $default = null)
    {
        if (array_key_exists($key, $inputs)) {
            if (!is_null($inputs[$key])) {
                return $inputs[$key];
            }
        }
        return $default;
    }
}
