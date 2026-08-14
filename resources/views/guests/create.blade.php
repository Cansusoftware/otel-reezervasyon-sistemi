@extends('layouts.app')

@section('title', 'Yeni Misafir')

@section('content')
<h1 class="mb-4"><i class="bi bi-plus-lg"></i> Yeni Misafir Ekle</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('misafirler.store') }}" method="POST">
            @csrf
            @include('guests._form')
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Kaydet</button>
                <a href="{{ route('misafirler.index') }}" class="btn btn-secondary">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection
