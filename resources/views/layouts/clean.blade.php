<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Perpustakaan Mini')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #F5F5F5;
            color: #333;
        }

        .navbar {
            background-color: #3F51B5;
            /* Warna biru indigo sama seperti layouts.app */
        }

        .navbar .navbar-brand {
            color: #fff;
            font-weight: 600;
        }

        .navbar .navbar-brand:hover {
            color: #C5CAE9;
        }

        .navbar .navbar-brand img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        footer {
            font-size: 0.9rem;
            border-top: 1px solid #CFD8DC;
            background-color: #E8EAF6;
            color: #607D8B;
        }
    </style>
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <img src="{{ asset('storage/covers/library.png') }}" alt="Logo Perpustakaan">
                <span>Perpustakaan Mini</span>
            </a>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container my-4">
        {{-- Flash Message (berhasil login, daftar, dll) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show small" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>


    {{-- Footer --}}
    <footer class="text-center py-3">
        <small>&copy; {{ date('Y') }} Perpustakaan Mini — Developed by Ilham Trinanda</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
