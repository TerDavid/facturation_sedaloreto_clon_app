<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBombaAguaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bomba'       => 'required|string|max:255',
            'id_ciudades' => 'required|exists:ciudades,id',
        ];
    }
}
