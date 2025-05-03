<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    // Si tu tabla se llama 'tarifas' (plural) Laravel la detecta,
    // pero para mayor claridad:
    protected $table = 'tarifas';

    // Los campos que quieres poder llenar vía create/update:
    protected $fillable = [
        'categoria',
        'rango_min',
        'rango_max',
        'tarifa_agua',
        'tarifa_alcantarillado',
        'cargo_fijo',
    ];
}
