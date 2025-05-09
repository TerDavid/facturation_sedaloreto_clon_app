<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'celular',
        'correo',
        'direccion',
        'estado',
        'codigo_suministro',
        'ciudad_id',
        'sector_id',           // ← lo agregamos
        'manzana_id',          // ← y también
        'medidor_id',
        'tarifa_id',
        'consumo_sin_medidor_id',
    ];

    // Relaciones
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function medidor()
    {
        return $this->belongsTo(Medidor::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    public function manzana()
    {
        return $this->belongsTo(Manzana::class, 'manzana_id');
    }

    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class);
    }

    public function consumoSinMedidor()
    {
        return $this->belongsTo(ConsumoSinMedidor::class, 'consumo_sin_medidor_id');
    }
}
