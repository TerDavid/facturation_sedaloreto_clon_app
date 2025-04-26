<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservorioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reservorio'    => 'required|string|max:255',
            'id_bomba_agua' => 'required|exists:bomba_agua,id',
        ];
    }
}
