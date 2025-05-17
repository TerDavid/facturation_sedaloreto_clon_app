<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consumo extends Model
{
    use HasFactory;

    protected $table = 'consumos';

    protected $fillable = [
        'cliente_id',
        'm3_consumidos',
        'hora_registro_consumo',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
