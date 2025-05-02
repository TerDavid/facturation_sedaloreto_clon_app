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
    ];

    public function reservorio()
    {
        return $this->belongsTo(\App\Models\Reservorio::class, 'id_reservorio');
    }
}
