<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsumoSinMedidor extends Model
{
    use HasFactory;

    protected $table = 'consumos_sin_medidor';

    protected $fillable = [
        'categoria',
        'descripcion',
        'asignado_m3',
        'asignado_m3_menos_5h',
        'asignado_m3_5h_o_mas',
    ];
}
