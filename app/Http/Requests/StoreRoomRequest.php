<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => ['required', 'string', 'max:20', 'unique:rooms,number'],
            'type' => ['required', Rule::in(array_keys(\App\Models\Room::TYPES))],
            'status' => ['required', Rule::in(array_keys(\App\Models\Room::STATUSES))],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'number.required' => 'Oda numarası zorunludur.',
            'number.unique' => 'Bu oda numarası zaten kayıtlı.',
            'type.required' => 'Oda tipi seçilmelidir.',
            'status.required' => 'Oda durumu seçilmelidir.',
            'price_per_night.required' => 'Gece fiyatı zorunludur.',
            'price_per_night.min' => 'Gece fiyatı sıfırdan küçük olamaz.',
            'capacity.required' => 'Kapasite zorunludur.',
        ];
    }
}
