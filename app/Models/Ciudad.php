<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PlantaTratamiento;
use App\Models\BombaAgua;
use App\Models\Reservorio;
use App\Models\Sector;

class Ciudad extends Model
{
    use HasFactory;

    protected $table = 'ciudades';
    protected $fillable = ['nombre'];

    public function plantasTratamiento()
    {
        return $this->hasMany(PlantaTratamiento::class, 'id_ciudades');
    }

    public function bombas()
    {
        return $this->hasMany(BombaAgua::class, 'id_ciudades');
    }

    /**
     * Todos los reservorios de esta ciudad.
     */
    public function reservorios()
    {
        return $this->hasMany(Reservorio::class, 'id_ciudades');
    }
    public function sectores2()
    {
        return $this->hasMany(Sector::class, 'id_ciudad');
    }

    /**
     * Todos los sectores de esta ciudad, a través de sus reservorios.
     */
    public function sectores()
    {
        return $this->hasManyThrough(
            Sector::class,       // modelo destino
            Reservorio::class,   // modelo intermedio
            'id_ciudades',       // FK en reservorio que apunta a ciudades.id
            'id_reservorio',     // FK en sector que apunta a reservorio.id
            'id',                // PK local en ciudades
            'id'                 // PK local en reservorio
        );
    }
}
