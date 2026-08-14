@php
    $roomStatusClass = [
        'musait' => 'success',
        'dolu' => 'danger',
        'bakim' => 'warning',
    ];
    $reservationStatusClass = [
        'beklemede' => 'primary',
        'giris_yapildi' => 'success',
        'cikis_yapildi' => 'secondary',
        'iptal' => 'danger',
    ];
@endphp

@if($type === 'room')
    <span class="badge bg-{{ $roomStatusClass[$status] ?? 'secondary' }}">
        {{ \App\Models\Room::STATUSES[$status] ?? $status }}
    </span>
@else
    <span class="badge bg-{{ $reservationStatusClass[$status] ?? 'secondary' }}">
        {{ \App\Models\Reservation::STATUSES[$status] ?? $status }}
    </span>
@endif
