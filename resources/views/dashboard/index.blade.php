@extends('layouts.app')

@section('title', 'Panel')

@section('content')
<h1 class="mb-4"><i class="bi bi-speedometer2"></i> Panel</h1>

{{-- Özet kartlar --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center border-primary">
            <div class="card-body">
                <h3 class="text-primary">{{ $stats['total_rooms'] }}</h3>
                <p class="text-muted mb-0">Toplam Oda</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-success">
            <div class="card-body">
                <h3 class="text-success">{{ $stats['available_rooms'] }}</h3>
                <p class="text-muted mb-0">Müsait Oda</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-danger">
            <div class="card-body">
                <h3 class="text-danger">{{ $stats['occupied_rooms'] }}</h3>
                <p class="text-muted mb-0">Dolu Oda</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-info">
            <div class="card-body">
                <h3 class="text-info">{{ $stats['active_reservations'] }}</h3>
                <p class="text-muted mb-0">Aktif Rezervasyon</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Bugün giriş yapacaklar --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-box-arrow-in-right"></i> Bugün Giriş Yapacaklar ({{ $todayCheckIns->count() }})
            </div>
            <div class="card-body p-0">
                @if($todayCheckIns->isEmpty())
                    <p class="text-muted p-3 mb-0">Bugün giriş yapacak misafir yok.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Misafir</th>
                                    <th>Oda</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayCheckIns as $reservation)
                                <tr>
                                    <td>{{ $reservation->guest->full_name }}</td>
                                    <td>{{ $reservation->room->number }}</td>
                                    <td>
                                        <form action="{{ route('rezervasyonlar.check-in', $reservation) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-lg"></i> Giriş Yap
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Bugün çıkış yapacaklar --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-warning">
                <i class="bi bi-box-arrow-right"></i> Bugün Çıkış Yapacaklar ({{ $todayCheckOuts->count() }})
            </div>
            <div class="card-body p-0">
                @if($todayCheckOuts->isEmpty())
                    <p class="text-muted p-3 mb-0">Bugün çıkış yapacak misafir yok.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Misafir</th>
                                    <th>Oda</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayCheckOuts as $reservation)
                                <tr>
                                    <td>{{ $reservation->guest->full_name }}</td>
                                    <td>{{ $reservation->room->number }}</td>
                                    <td>
                                        <form action="{{ route('rezervasyonlar.check-out', $reservation) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="bi bi-check-lg"></i> Çıkış Yap
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Son rezervasyonlar --}}
<div class="card mt-4">
    <div class="card-header">
        <i class="bi bi-clock-history"></i> Son Rezervasyonlar
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Misafir</th>
                        <th>Oda</th>
                        <th>Giriş</th>
                        <th>Çıkış</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentReservations as $reservation)
                    <tr>
                        <td>{{ $reservation->guest->full_name }}</td>
                        <td>{{ $reservation->room->number }}</td>
                        <td>{{ $reservation->check_in->format('d.m.Y') }}</td>
                        <td>{{ $reservation->check_out->format('d.m.Y') }}</td>
                        <td>@include('partials.status-badge', ['type' => 'reservation', 'status' => $reservation->status])</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted text-center">Henüz rezervasyon yok.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
