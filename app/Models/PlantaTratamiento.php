<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantaTratamiento extends Model
{
    use HasFactory;

    protected $table = 'planta_tratamiento';

    protected $fillable = [
        'sector',
        'reservorio',
        'bomba_agua',
        'id_ciudades',
    ];

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'id_ciudades');
    }
}
