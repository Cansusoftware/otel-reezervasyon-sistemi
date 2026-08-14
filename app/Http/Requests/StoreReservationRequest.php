<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guest_id' => ['required', 'exists:guests,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'status' => ['required', Rule::in(array_keys(Reservation::STATUSES))],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'guest_id.required' => 'Misafir seçilmelidir.',
            'guest_id.exists' => 'Seçilen misafir bulunamadı.',
            'room_id.required' => 'Oda seçilmelidir.',
            'room_id.exists' => 'Seçilen oda bulunamadı.',
            'check_in.required' => 'Giriş tarihi zorunludur.',
            'check_out.required' => 'Çıkış tarihi zorunludur.',
            'check_out.after' => 'Çıkış tarihi giriş tarihinden sonra olmalıdır.',
            'status.required' => 'Durum seçilmelidir.',
        ];
    }

    /** Tarih çakışması kontrolü */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $excludeId = $this->route('rezervasyon')?->id;

            if ($this->input('status') === 'iptal') {
                return;
            }

            if (Reservation::hasConflict(
                (int) $this->input('room_id'),
                $this->input('check_in'),
                $this->input('check_out'),
                $excludeId
            )) {
                $validator->errors()->add('room_id', 'Bu oda seçilen tarihlerde başka bir rezervasyona ayrılmış.');
            }
        });
    }
}
