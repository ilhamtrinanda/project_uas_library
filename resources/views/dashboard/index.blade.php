@extends('layouts.app')

@section('content')
    <div class="container position-relative bg-dashboard">
        {{-- alert edit --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Profil Anggota (Khusus Role: anggota) --}}
        @auth
            @if (auth()->user()->role === 'anggota')
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center">
                        <img src="{{ auth()->user()->photo_url }}" alt="Profil" class="rounded-circle me-3"
                            style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                            <p class="mb-0 text-muted small">{{ auth()->user()->email }}</p>
                            <p class="mb-0 text-muted small">Terdaftar sejak: {{ auth()->user()->created_at->format('d M Y') }}
                            </p>
                            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary mt-2">Edit Profil</a>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

        {{-- Kartu Statistik --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 stat-card text-white" style="background-color: #5C6BC0;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-white text-primary me-3">
                            <i class="bi bi-book fs-3"></i>
                        </div>
                        <div>
                            <small>Total Buku</small>
                            <h5 class="mb-0 fw-semibold">{{ $books->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 stat-card text-white" style="background-color: #4CAF50;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-white text-success me-3">
                            <i class="bi bi-person-vcard fs-3"></i>
                        </div>
                        <div>
                            <small>Total Anggota</small>
                            <h5 class="mb-0 fw-semibold">{{ \App\Models\User::where('role', 'anggota')->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 stat-card text-white" style="background-color: #FF9800;">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-white text-warning me-3">
                            <i class="bi bi-journal-check fs-3"></i>
                        </div>
                        <div>
                            <small>Buku Dipinjam</small>
                            <h5 class="mb-0 fw-semibold">{{ $totalLoanedBooks }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Buku Terbaru --}}
        <div class="card shadow-sm mb-4 border-0 book-slider-card">
            <div class="card-body position-relative">
                <h5 class="card-title mb-3 text-primary fw-semibold">
                    <i class="bi bi-clock me-1"></i> Buku Terbaru
                </h5>

                @if ($latestBooks->isEmpty())
                    <p class="text-muted">Belum ada buku yang ditambahkan.</p>
                @else
                    <div class="position-relative">
                        {{-- Panah kiri --}}
                        <button type="button"
                            class="btn btn-scroll-arrow position-absolute top-50 start-0 translate-middle-y"
                            onclick="scrollBooks('left')" aria-label="Scroll kiri">
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        {{-- Slider --}}
                        <div id="bookScroll" class="d-flex py-2 ps-5 pe-4"
                            style="overflow: hidden; scroll-behavior: smooth; position: relative;">
                            @foreach ($latestBooks as $book)
                                <div class="me-3 flex-shrink-0" style="width: 200px;">
                                    <a href="{{ route('books.show', ['book' => $book->id, 'from' => 'dashboard']) }}"
                                        class="text-decoration-none text-dark" title="{{ $book->title }}">
                                        <div class="card h-100 shadow-sm border-0 book-card hover-shadow">
                                            @if ($book->cover)
                                                <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('images/no-cover.png') }}"
                                                    class="card-img-top rounded-top" alt="{{ $book->title }}"
                                                    style="width: 100%; height: 250px; object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/200x250?text=No+Cover"
                                                    class="card-img-top rounded-top" alt="No cover">
                                            @endif

                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1 text-truncate">
                                                    {{ $book->title }}
                                                </h6>
                                                <p class="card-text mb-0">
                                                    <small class="text-muted"><strong>Penulis:</strong>
                                                        {{ $book->author }}</small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        {{-- Panah kanan --}}
                        <button type="button"
                            class="btn btn-scroll-arrow position-absolute top-50 end-0 translate-middle-y"
                            onclick="scrollBooks('right')" aria-label="Scroll kanan">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-dashboard {
            background-color: #FAFAFA;
            border-radius: 10px;
            padding: 20px;
        }

        .stat-card small {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            background-color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .book-slider-card {
            background-color: #ffffff;
            border-radius: 8px;
        }

        .book-card {
            background-color: #F5F5F5;
            border-radius: 8px;
            transition: 0.3s ease-in-out;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .btn-scroll-arrow {
            background-color: #3F51B5;
            color: white;
            border: none;
            width: 38px;
            height: 38px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            z-index: 10;
        }

        .btn-scroll-arrow:hover {
            background-color: #303F9F;
        }

        #bookScroll {
            overflow: hidden;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function scrollBooks(direction) {
            const container = document.getElementById('bookScroll');
            if (!container) return;

            const scrollAmount = 220;
            const maxScrollLeft = container.scrollWidth - container.clientWidth;

            if (direction === 'left') {
                if (container.scrollLeft <= 0) {
                    container.scrollLeft = maxScrollLeft;
                } else {
                    container.scrollLeft -= scrollAmount;
                }
            } else if (direction === 'right') {
                if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 5) {
                    container.scrollLeft = 0;
                } else {
                    container.scrollLeft += scrollAmount;
                }
            }
        }
    </script>
@endpush
