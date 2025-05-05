<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTecnicoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Para ignorar el mismo registro en unique
        $tecnicoId = $this->route('tecnico')->id;

        return [
            'nombre'    => 'required|string|max:100',
            'apellido'  => 'required|string|max:100',
            'usuario'   => "required|string|max:50|unique:tecnicos,usuario,{$tecnicoId}",
            'email'     => "required|email|max:150|unique:tecnicos,email,{$tecnicoId}",
            'password'  => 'nullable|string|min:8|confirmed',
            'role_id'   => 'required|integer|exists:roles,id',
        ];
    }
}
