<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Frontdesk') — Ön Büro Yazılımı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

@if(auth()->check())
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-building"></i> Frontdesk
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Panel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('odalar.*') ? 'active' : '' }}" href="{{ route('odalar.index') }}">
                        <i class="bi bi-door-open"></i> Odalar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('misafirler.*') ? 'active' : '' }}" href="{{ route('misafirler.index') }}">
                        <i class="bi bi-people"></i> Misafirler
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rezervasyonlar.*') ? 'active' : '' }}" href="{{ route('rezervasyonlar.index') }}">
                        <i class="bi bi-calendar-check"></i> Rezervasyonlar
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link text-white-50">{{ auth()->user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-box-arrow-right"></i> Çıkış
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endif

<div class="container pb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
