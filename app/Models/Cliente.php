<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'code_suministro',
        'nombre',
        'apellido',
        'dni',
        'direccion',
        'telefono',
        'email',
        'id_manzana',
        'categoria',
        'tarifa_id',
        'id_consumo_sin_medidor',
    ];

    public function manzana()
    {
        return $this->belongsTo(Manzana::class, 'id_manzana');
    }

    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class);
    }

    public function consumoSinMedidor()
    {
        return $this->belongsTo(ConsumoSinMedidor::class, 'id_consumo_sin_medidor');
    }

    public function medidor()
    {
        return $this->hasOne(Medidor::class, 'cliente_id');
    }

    public function consumos()
    {
        return $this->hasMany(Consumo::class, 'cliente_id');
    }
}
