<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManzanaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'manzana'   => 'required|string|max:255',
            'id_sector' => 'required|exists:sector,id',
        ];
    }
}
