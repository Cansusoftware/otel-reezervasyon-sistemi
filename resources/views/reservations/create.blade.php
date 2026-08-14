@extends('layouts.app')

@section('title', 'Yeni Rezervasyon')

@section('content')
<h1 class="mb-4"><i class="bi bi-plus-lg"></i> Yeni Rezervasyon</h1>

@if($guests->isEmpty())
    <div class="alert alert-warning">
        Rezervasyon oluşturmak için önce en az bir misafir eklemelisiniz.
        <a href="{{ route('misafirler.create') }}">Misafir ekle</a>
    </div>
@elseif($rooms->isEmpty())
    <div class="alert alert-warning">
        Rezervasyon oluşturmak için önce en az bir oda eklemelisiniz.
        <a href="{{ route('odalar.create') }}">Oda ekle</a>
    </div>
@else
<div class="card">
    <div class="card-body">
        <form action="{{ route('rezervasyonlar.store') }}" method="POST">
            @csrf
            @include('reservations._form')
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Kaydet</button>
                <a href="{{ route('rezervasyonlar.index') }}" class="btn btn-secondary">İptal</a>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
