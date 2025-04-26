<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlantaTratamientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sector'       => 'required|string|max:255',
            'reservorio'   => 'required|string|max:255',
            'bomba_agua'   => 'required|string|max:255',
            'id_ciudades'  => 'required|exists:ciudades,id',
        ];
    }
}
