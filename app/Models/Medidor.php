<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medidor extends Model
{
    use HasFactory;

    /**
     * Laravel por convención
     * habría buscado 'medidors' o 'medidor',
     * así que forzamos el nombre correcto:
     */
    protected $table = 'medidores';

    /**
     * Campos rellenables.
     */
    protected $fillable = [
        'cliente_id',
        'codigo',
        'fecha_instalacion',
        'ubicacion_detallada',
    ];

    /**
     * Relación inversa con Cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
