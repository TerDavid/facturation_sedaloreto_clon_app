<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manzana extends Model
{
    use HasFactory;

    protected $table = 'manzana';

    protected $fillable = [
        'manzana',
        'id_sector',
        'id_reservorio',
        'id_bomba_agua',
        'id_ciudad',
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'id_sector');
    }

    public function reservorio()
    {
        return $this->belongsTo(Reservorio::class, 'id_reservorio');
    }

    public function bomba()
    {
        return $this->belongsTo(BombaAgua::class, 'id_bomba_agua');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'id_ciudad');
    }
}

