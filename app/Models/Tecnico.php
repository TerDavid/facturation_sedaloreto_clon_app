<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tecnico extends Authenticatable
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     * Si tu tabla se llama "tecnicos", puedes omitir esta propiedad.
     */
    // protected $table = 'tecnicos';

    /**
     * Los atributos que se pueden asignar de forma masiva.
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'usuario',
        'email',
        'password',
        'role_id',
    ];

    /**
     * Los atributos que deben ocultarse en los arrays/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los casts de atributos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
