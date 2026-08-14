@extends('layouts.app')

@section('title', 'Yeni Oda')

@section('content')
<h1 class="mb-4"><i class="bi bi-plus-lg"></i> Yeni Oda Ekle</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('odalar.store') }}" method="POST">
            @csrf
            @include('rooms._form')
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Kaydet</button>
                <a href="{{ route('odalar.index') }}" class="btn btn-secondary">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
