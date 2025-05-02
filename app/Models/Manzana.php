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
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'id_sector');
    }
}
