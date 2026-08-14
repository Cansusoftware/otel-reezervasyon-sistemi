@extends('layouts.app')

@section('title', 'Oda Düzenle')

@section('content')
<h1 class="mb-4"><i class="bi bi-pencil"></i> Oda Düzenle — {{ $room->number }}</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('odalar.update', $room) }}" method="POST">
            @csrf
            @method('PUT')
            @include('rooms._form', ['room' => $room])
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Güncelle</button>
                <a href="{{ route('odalar.index') }}" class="btn btn-secondary">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
