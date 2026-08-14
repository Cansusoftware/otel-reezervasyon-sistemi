@extends('layouts.app')

@section('title', 'Misafir Düzenle')

@section('content')
<h1 class="mb-4"><i class="bi bi-pencil"></i> Misafir Düzenle — {{ $guest->full_name }}</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('misafirler.update', $guest) }}" method="POST">
            @csrf
            @method('PUT')
            @include('guests._form', ['guest' => $guest])
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Güncelle</button>
                <a href="{{ route('misafirler.index') }}" class="btn btn-secondary">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
