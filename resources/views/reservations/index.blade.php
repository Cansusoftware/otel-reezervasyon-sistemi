@extends('layouts.app')

@section('title', 'Rezervasyonlar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-calendar-check"></i> Rezervasyonlar</h1>
    <a href="{{ route('rezervasyonlar.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Yeni Rezervasyon
    </a>
</div>

{{-- Filtreler --}}
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">Tüm Durumlar</option>
            @foreach(\App\Models\Reservation::STATUSES as $key => $label)
                <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <input type="date" name="from" class="form-control" value="{{ request('from') }}" placeholder="Başlangıç">
    </div>
    <div class="col-md-3">
        <input type="date" name="to" class="form-control" value="{{ request('to') }}" placeholder="Bitiş">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-funnel"></i> Filtrele</button>
        <a href="{{ route('rezervasyonlar.index') }}" class="btn btn-outline-secondary">Temizle</a>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Misafir</th>
                    <th>Oda</th>
                    <th>Giriş</th>
                    <th>Çıkış</th>
                    <th>Gece</th>
                    <th>Tutar</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->guest->full_name }}</td>
                    <td>{{ $reservation->room->number }}</td>
                    <td>{{ $reservation->check_in->format('d.m.Y') }}</td>
                    <td>{{ $reservation->check_out->format('d.m.Y') }}</td>
                    <td>{{ $reservation->night_count }}</td>
                    <td>{{ number_format($reservation->total_price, 2, ',', '.') }} ₺</td>
                    <td>@include('partials.status-badge', ['type' => 'reservation', 'status' => $reservation->status])</td>
                    <td>
                        @if($reservation->status === 'beklemede')
                            <form action="{{ route('rezervasyonlar.check-in', $reservation) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" title="Giriş Yap"><i class="bi bi-box-arrow-in-right"></i></button>
                            </form>
                        @endif
                        @if($reservation->status === 'giris_yapildi')
                            <form action="{{ route('rezervasyonlar.check-out', $reservation) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-warning" title="Çıkış Yap"><i class="bi bi-box-arrow-right"></i></button>
                            </form>
                        @endif
                        <a href="{{ route('rezervasyonlar.edit', $reservation) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if(!in_array($reservation->status, ['cikis_yapildi', 'iptal']))
                            <form action="{{ route('rezervasyonlar.cancel', $reservation) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="İptal"><i class="bi bi-x-lg"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-muted text-center">Rezervasyon bulunamadı.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $reservations->links() }}</div>
@endsection
