<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservorio extends Model
{
    use HasFactory;

    protected $table = 'reservorio';

    protected $fillable = [
        'reservorio',
        'id_bomba_agua',
        'id_ciudad',
    ];

    public function bomba()
    {
        return $this->belongsTo(BombaAgua::class, 'id_bomba_agua');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'id_ciudad');
    }

    public function sectores()
    {
        return $this->hasMany(Sector::class, 'id_reservorio');
    }
}

