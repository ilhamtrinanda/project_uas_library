<nav class="navbar navbar-expand-lg" style="background-color: #fde4b3; min-height: 60px;">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center gap-2 text-dark fw-bold" href="{{ route('dashboard') }}">
            <img src="{{ asset('storage/covers/library.png') }}" alt="Logo"
                style="height: 70px; object-fit: contain; margin-top: -10px;">
            <span class="fs-4">Perpustakaan Mini</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            {{-- Kiri --}}
            <ul class="navbar-nav gap-2">
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
                @endauth
            </ul>

            {{-- Tengah: Form Search --}}
            <form class="d-flex search-form" role="search" action="{{ route('books.index') }}" method="GET">
                <input class="form-control form-control-sm me-2 rounded-pill px-3 shadow-sm border-0" type="search"
                    name="search" placeholder="Cari judul atau penulis..." value="{{ request('search') }}"
                    aria-label="Search" style="background-color: #fffaf0; max-width: 300px;">
                <button class="btn btn-sm rounded-pill shadow-sm px-3 text-white" style="background-color: #FF7043;"
                    type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>

            {{-- Kanan --}}
            <ul class="navbar-nav align-items-center gap-2">
                @auth
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
                            <button type="submit" class="btn btn-danger btn-sm px-3 fw-bold ms-2">Logout</button>
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
