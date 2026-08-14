@extends('layouts.app')

@section('title', 'Odalar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-door-open"></i> Odalar</h1>
    <a href="{{ route('odalar.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Yeni Oda
    </a>
</div>

{{-- Filtre --}}
<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Tüm Durumlar</option>
            @foreach(\App\Models\Room::STATUSES as $key => $label)
                <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Oda No</th>
                    <th>Tip</th>
                    <th>Durum</th>
                    <th>Gece Fiyatı</th>
                    <th>Kapasite</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr>
                    <td><strong>{{ $room->number }}</strong></td>
                    <td>{{ $room->type_label }}</td>
                    <td>@include('partials.status-badge', ['type' => 'room', 'status' => $room->status])</td>
                    <td>{{ number_format($room->price_per_night, 2, ',', '.') }} ₺</td>
                    <td>{{ $room->capacity }} kişi</td>
                    <td>
                        <a href="{{ route('odalar.edit', $room) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('odalar.destroy', $room) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Bu odayı silmek istediğinize emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-muted text-center">Henüz oda eklenmemiş.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $rooms->links() }}</div>
@endsection
