@extends('layouts.app')

@section('title', 'Misafirler')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-people"></i> Misafirler</h1>
    <a href="{{ route('misafirler.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Yeni Misafir
    </a>
</div>

{{-- Arama --}}
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Ad, soyad veya telefon ara..."
               value="{{ $search }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i> Ara</button>
        @if($search)
            <a href="{{ route('misafirler.index') }}" class="btn btn-outline-secondary">Temizle</a>
        @endif
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Ad Soyad</th>
                    <th>Telefon</th>
                    <th>E-posta</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $guest)
                <tr>
                    <td>
                        <a href="{{ route('misafirler.show', $guest) }}">{{ $guest->full_name }}</a>
                    </td>
                    <td>{{ $guest->phone }}</td>
                    <td>{{ $guest->email ?? '—' }}</td>
                    <td>
                        <a href="{{ route('misafirler.show', $guest) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('misafirler.edit', $guest) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('misafirler.destroy', $guest) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Bu misafiri silmek istediğinize emin misiniz?')">
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
                    <td colspan="4" class="text-muted text-center">Misafir bulunamadı.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $guests->links() }}</div>
@endsection
