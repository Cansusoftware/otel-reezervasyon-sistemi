@extends('layouts.app')

@section('title', $guest->full_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-person"></i> {{ $guest->full_name }}</h1>
    <div>
        <a href="{{ route('misafirler.edit', $guest) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Düzenle
        </a>
        <a href="{{ route('misafirler.index') }}" class="btn btn-secondary">Geri</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">İletişim Bilgileri</div>
            <div class="card-body">
                <p><strong>Telefon:</strong> {{ $guest->phone }}</p>
                <p><strong>E-posta:</strong> {{ $guest->email ?? '—' }}</p>
                <p><strong>Kimlik No:</strong> {{ $guest->id_number ?? '—' }}</p>
                @if($guest->notes)
                    <p><strong>Notlar:</strong> {{ $guest->notes }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Rezervasyon Geçmişi</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Oda</th>
                                <th>Giriş</th>
                                <th>Çıkış</th>
                                <th>Gece</th>
                                <th>Tutar</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guest->reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->room->number }}</td>
                                <td>{{ $reservation->check_in->format('d.m.Y') }}</td>
                                <td>{{ $reservation->check_out->format('d.m.Y') }}</td>
                                <td>{{ $reservation->night_count }}</td>
                                <td>{{ number_format($reservation->total_price, 2, ',', '.') }} ₺</td>
                                <td>@include('partials.status-badge', ['type' => 'reservation', 'status' => $reservation->status])</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-muted text-center">Henüz rezervasyon yok.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
