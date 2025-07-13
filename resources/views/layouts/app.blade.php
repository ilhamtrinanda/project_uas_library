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

            .btn-logout {
                background-color: #FF7043;
                border: none;
                color: #fff;
                padding: 6px 12px;
                border-radius: 20px;
                font-weight: 500;
                transition: background-color 0.2s ease, transform 0.2s ease;
            }

            .btn-logout:hover {
                background-color: #F4511E;
                transform: scale(1.05);
            }
        </style>

    </head>

    <body>

        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-custom shadow-sm" style="min-height: 60px;">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                    <img src="{{ asset('storage/covers/library.png') }}" alt="Logo Perpustakaan"
                        style="height: 50px; width: auto; object-fit: contain;">
                    <span class="fs-5 fw-bold">Perpustakaan Mini</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center gap-2">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                    href="{{ route('dashboard') }}">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}"
                                    href="{{ route('books.index') }}">
                                    Daftar Buku
                                </a>
                            </li>
                            @if (auth()->user()->role === 'anggota')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('loans.index') ? 'active' : '' }}"
                                        href="{{ route('loans.index') }}">
                                        Peminjaman
                                    </a>
                                </li>
                            @endif

                            @if (auth()->user()->role === 'anggota')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}"
                                        href="{{ route('favorites.index') }}">
                                        Favorit
                                    </a>
                                </li>
                            @endif

                            @if (in_array(auth()->user()->role, ['admin', 'petugas']))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('loans.*') ? 'active' : '' }}"
                                        href="{{ route('loans.index') }}">
                                        Peminjaman
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                                        href="{{ route('users.index') }}">
                                        Anggota
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-logout ms-2">
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
                                <div class="auth-form bg-white rounded-4 shadow-lg p-4">
                                    <h4 class="text-center mb-4 fw-bold text-primary">Login</h4>

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

                                    {{-- Form Login --}}
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" id="email"
                                                class="form-control rounded-3" placeholder="Email" required autofocus>
                                            <label for="email">Email</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" name="password" id="password"
                                                class="form-control rounded-3" placeholder="Password" required>
                                            <label for="password">Password</label>
                                        </div>

                                        <div class="form-check mb-3 small">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">
                                                Ingat Saya
                                            </label>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-pill">
                                            Login
                                        </button>

                                        <div class="text-center mt-3 small">
                                            Belum punya akun? <a href="{{ route('register') }}"
                                                class="text-decoration-none fw-semibold" style="color: #FF7043;">
                                                Daftar sekarang
                                            </a>
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
