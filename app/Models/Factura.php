<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';

    protected $fillable = [
        'cliente_id',
        'ciudad_id',
        'sector_id',
        'manzana_id',
        'medidor_id',
        'tarifa_id',
        'consumo_sin_medidor_id',
        'fecha_emision',
        'fecha_vencimiento',
        'valor_pago',
        'numero_recibo',
        'mes_factura',
    ];

    /**
     * Casteo de columnas a tipos nativos
     */
    protected $casts = [
        'fecha_emision'     => 'date',      // ahora es Carbon
        'fecha_vencimiento' => 'date',      // ahora es Carbon
        'valor_pago'        => 'decimal:2', // opcional, formatea bien
    ];

    // Relaciones
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }

    public function manzana(): BelongsTo
    {
        return $this->belongsTo(Manzana::class);
    }

    public function medidor(): BelongsTo
    {
        return $this->belongsTo(Medidor::class);
    }

    public function tarifa(): BelongsTo
    {
        return $this->belongsTo(Tarifa::class);
    }

    public function consumoSinMedidor(): BelongsTo
    {
        return $this->belongsTo(ConsumoSinMedidor::class, 'consumo_sin_medidor_id');
    }
}
