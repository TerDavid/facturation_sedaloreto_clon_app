<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    // Si tu tabla se llama 'ciudades' (plural), Laravel la detecta automáticamente
    // pero por claridad puedes ponerlo explícito:
    protected $table = 'ciudades';

    // Campos asignables
    protected $fillable = ['nombre'];

    // Relación inversa (opcional)
    public function plantasTratamiento()
    {
        return $this->hasMany(PlantaTratamiento::class, 'id_ciudades');
    }
}
