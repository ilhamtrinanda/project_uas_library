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
                background-color: #ECEFF1;
                color: #263238;
            }

            .navbar-custom,
            nav.navbar {
                background-color: #3F51B5 !important;
                /* Indigo Maskulin */
            }

            .navbar-custom .navbar-brand,
            .navbar-custom .nav-link,
            nav.navbar .navbar-brand,
            nav.navbar .nav-link {
                color: #ffffff !important;
            }

            .navbar-custom .nav-link:hover,
            nav.navbar .nav-link:hover {
                color: #C5CAE9 !important;
            }

            .hero {
                background: linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3)),
                    url('{{ url('storage/covers/latarbelakang.jpg') }}') center/cover no-repeat;
                min-height: 500px;
                color: white;
                position: relative;
            }

            .hero-overlay {
                background: rgba(255, 255, 255, 0.05);
                min-height: 500px;
                display: flex;
                align-items: center;
                padding: 60px 0;
                backdrop-filter: blur(4px);
            }

            .auth-form {
                background-color: #ffffff;
                color: black;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            }

            .nav-link.active {
                font-weight: bold;
                color: #FFC107 !important;
            }

            .btn-custom-register {
                background-color: #FF7043;
                /* Oranye gelap */
                border: none;
                color: #fff;
                transition: background-color 0.3s ease, transform 0.2s ease;
                font-weight: 500;
            }

            .btn-custom-register:hover {
                background-color: #F4511E;
                transform: scale(1.05);
            }

            .btn-warning {
                background-color: #3F51B5;
                color: white;
                border: none;
            }

            .btn-warning:hover {
                background-color: #303F9F;
                color: white;
            }

            .footer-navbar {
                background-color: #3F51B5;
                /* Sama seperti navbar */
                color: #ffffff;
                /* Teks putih */
                font-size: 0.9rem;
            }
        </style>

    </head>

    <body>

        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg" style="background-color: #fde4b3; min-height: 60px; overflow: hidden;">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2 text-dark fw-bold position-relative"
                    href="{{ route('dashboard') }}">
                    <img src="{{ asset('storage/covers/library.png') }}" alt="Logo Perpustakaan"
                        style="height: 70px; width: auto; object-fit: contain; margin-top: -10px;">
                    <span class="fs-4">Perpustakaan Mini</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center gap-2">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link text-dark {{ request()->routeIs('dashboard') ? 'fw-bold' : 'fw-semibold' }}"
                                    href="{{ route('dashboard') }}">
                                    <i class="bi bi-house-door me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark {{ request()->routeIs('books.*') ? 'fw-bold' : 'fw-semibold' }}"
                                    href="{{ route('books.index') }}">
                                    <i class="bi bi-journal-text me-1"></i> Daftar Buku
                                </a>
                            </li>

                            @if (auth()->user()->role === 'anggota')
                                <li class="nav-item">
                                    <a class="nav-link text-dark {{ request()->routeIs('favorites.*') ? 'fw-bold' : 'fw-semibold' }}"
                                        href="{{ route('favorites.index') }}">
                                        <i class="bi bi-star me-1"></i> Favorit
                                    </a>
                                </li>
                            @endif

                            @if (in_array(auth()->user()->role, ['admin', 'petugas']))
                                <li class="nav-item">
                                    <a class="nav-link text-dark {{ request()->routeIs('loans.*') ? 'fw-bold' : 'fw-semibold' }}"
                                        href="{{ route('loans.index') }}">
                                        <i class="bi bi-bookmark-check me-1"></i> Peminjaman
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark {{ request()->routeIs('users.*') ? 'fw-bold' : 'fw-semibold' }}"
                                        href="{{ route('users.index') }}">
                                        <i class="bi bi-people me-1"></i> Anggota
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm px-3 fw-bold ms-2">
                                        Logout
                                    </button>
                                </form>
                            </li>

                        @endauth

                        @guest
                            <li class="nav-item">
                                <a href="{{ route('register') }}"
                                    class="btn btn-custom-register px-4 py-2 fw-semibold rounded-pill shadow-sm">
                                    Daftar
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        @guest
            <section class="hero">
                <div class="hero-overlay">
                    <div class="container text-white">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="display-5 fw-bold">Selamat Datang di Perpustakaan Mini</h1>
                                <p class="lead">Silakan login untuk meminjam dan mengelola buku favoritmu.</p>
                            </div>
                            <div class="col-md-5 offset-md-1">
                                <div class="auth-form px-3 py-4 shadow-sm rounded-4">
                                    <h5 class="text-center fw-semibold mb-3" style="color: #3F51B5;">Login</h5>

                                    {{-- Flash Message --}}
                                    @if (session('error'))
                                        <div class="alert alert-danger small">{{ session('error') }}</div>
                                    @endif

                                    @if (session('status'))
                                        <div class="alert alert-success small">{{ session('status') }}</div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger small">
                                            <ul class="mb-0 ps-3">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    {{-- Form --}}
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-floating mb-2">
                                            <input type="email" name="email" class="form-control form-control-sm"
                                                id="email" placeholder="Email" required autofocus>
                                            <label for="email">Email</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <input type="password" name="password" class="form-control form-control-sm"
                                                id="password" placeholder="Password" required>
                                            <label for="password">Password</label>
                                        </div>

                                        <div class="form-check mb-3 small">
                                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                            <label class="form-check-label" for="remember">Ingat Saya</label>
                                        </div>

                                        <button type="submit" class="btn btn-sm w-100 text-white fw-semibold"
                                            style="background-color: #3F51B5;">
                                            Login
                                        </button>

                                        <div class="text-center mt-3 small">
                                            Belum punya akun? <a href="{{ route('register') }}"
                                                class="text-decoration-none" style="color: #FF7043;">Daftar</a>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endguest

        {{-- Main Content --}}
        <main class="container my-4">
            @yield('content')
        </main>

        <footer class="text-center py-3 footer-navbar">
            <small>&copy; {{ date('Y') }} Perpustakaan Mini — Developed by Ilham Trinanda</small>
        </footer>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>

    </html>
