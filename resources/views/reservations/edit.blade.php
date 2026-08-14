@extends('layouts.app')

@section('title', 'Rezervasyon Düzenle')

@section('content')
<h1 class="mb-4"><i class="bi bi-pencil"></i> Rezervasyon Düzenle</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('rezervasyonlar.update', $reservation) }}" method="POST">
            @csrf
            @method('PUT')
            @include('reservations._form', ['reservation' => $reservation])
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Güncelle</button>
                <a href="{{ route('rezervasyonlar.index') }}" class="btn btn-secondary">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
