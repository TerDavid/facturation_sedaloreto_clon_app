<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTecnicoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // O revisa aquí permisos si lo necesitas
    }

    public function rules()
    {
        return [
            'nombre'    => 'required|string|max:100',
            'apellido'  => 'required|string|max:100',
            'usuario'   => 'required|string|max:50|unique:tecnicos,usuario',
            'email'     => 'required|email|max:150|unique:tecnicos,email',
            'password'  => 'required|string|min:8|confirmed',
            'role_id'   => 'required|integer|exists:roles,id',
        ];
    }
}
