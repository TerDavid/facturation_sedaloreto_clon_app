<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Lectura.php

// app/Models/Lectura.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lectura extends Model
{
    protected $table = 'lecturas';

    protected $fillable = [
        'tecnico_id',
        'medidor_id',
        'codigo_suministro',
        'valor',
        'fecha_lectura',
    ];

    /**
     * Lectura pertenece a un técnico.
     */
    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(Tecnico::class);
    }

    /**
     * Lectura pertenece a un medidor.
     */
    public function medidor(): BelongsTo
    {
        return $this->belongsTo(Medidor::class);
    }

    /**
     * Lectura pertenece a un cliente via código de suministro.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'codigo_suministro', 'codigo_suministro');
    }
}
