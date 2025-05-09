<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $table = 'sector';

    protected $fillable = [
        'sector',
        'id_reservorio',
        'id_bomba_agua',
        'id_ciudad',
    ];

    public function reservorio()
    {
        return $this->belongsTo(\App\Models\Reservorio::class, 'id_reservorio');
    }

    public function bomba()
    {
        return $this->belongsTo(\App\Models\BombaAgua::class, 'id_bomba_agua');
    }

    public function ciudad()
    {
        return $this->belongsTo(\App\Models\Ciudad::class, 'id_ciudad');
    }

    public function manzanas()
    {
        return $this->hasMany(\App\Models\Manzana::class, 'id_sector');
    }
}
