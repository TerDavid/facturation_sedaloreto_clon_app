<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{

    protected $table = "cat_document_types";
    public $incrementing = false;

    const BOLETA = '03';
    const FACTURA = '01';
}
