<?php

namespace App\Models;


class DocumentConfiguration
{
    protected $fillable = [
        'seller',
        'show_external_seller'
    ];

    protected static $document_configurations = [
        [
            'id' => 1,
            'seller' => 0,
            'show_external_seller' => 0,
            'show_logo_in_pdf' => 1,
            'document_sucursal' => 1,
            'created_at' => '2020-06-05 00:00:00',
            'updated_at' => '2020-06-05 00:00:00',
        ],
    ];

    public static function first()
    {
        return (object)self::$document_configurations[0];
    }
}
