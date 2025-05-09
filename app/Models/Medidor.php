<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medidor extends Model
{
    use HasFactory;

    protected $table = 'medidor';

    protected $fillable = [
        'codigo_medidor',
        'id_sector',
        'id_manzana',
        'ciudad_id',
        'estado_medidor',
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'id_sector');
    }

    public function manzana()
    {
        return $this->belongsTo(Manzana::class, 'id_manzana');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }
}
