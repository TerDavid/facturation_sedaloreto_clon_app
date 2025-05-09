<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManzanaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'manzana'        => 'required|string|max:255',
        'id_sector'      => 'required|exists:sector,id',
        'id_reservorio'  => 'required|exists:reservorio,id',
        'id_bomba_agua'  => 'required|exists:bomba_agua,id',
        'id_ciudad'      => 'required|exists:ciudades,id',
    ];
}

}
