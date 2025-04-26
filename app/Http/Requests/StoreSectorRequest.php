<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sector'         => 'required|string|max:255',
            'id_reservorio'  => 'required|exists:reservorio,id',
        ];
    }
}
