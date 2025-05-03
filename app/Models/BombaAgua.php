<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BombaAgua extends Model
{
    use HasFactory;

    protected $table = 'bomba_agua';

    protected $fillable = [
        'bomba',
        'id_ciudades',
    ];

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'id_ciudades');
    }

    public function reservorios()
    {
        return $this->hasMany(Reservorio::class, 'id_bomba_agua');
    }
}
