<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => ['required', 'string', 'max:20', Rule::unique('rooms', 'number')->ignore($this->route('oda'))],
            'type' => ['required', Rule::in(array_keys(\App\Models\Room::TYPES))],
            'status' => ['required', Rule::in(array_keys(\App\Models\Room::STATUSES))],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return (new StoreRoomRequest())->messages();
    }
}
