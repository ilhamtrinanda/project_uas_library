@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Header dan Tombol Tambah Buku --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0 fw-bold">Daftar Buku</h3>
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('books.create') }}" class="btn btn-sm btn-success fw-semibold">
                        + Tambah Buku
                    </a>
                @endif
            @endauth
        </div>

        {{-- Alert Sukses / Error --}}
        @foreach (['success', 'error'] as $msg)
            @if (session($msg))
                <div class="alert alert-{{ $msg === 'success' ? 'success' : 'danger' }} alert-dismissible fade show small"
                    role="alert">
                    {{ session($msg) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif
        @endforeach

        {{-- Form untuk Peminjaman oleh Anggota --}}
        @auth
            @if (auth()->user()->role === 'anggota')
                <form action="{{ route('loans.requestMultiple') }}" method="POST" id="loanForm">
                    @csrf
            @endif
        @endauth

        {{-- Daftar Buku --}}
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @forelse($books as $book)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="book-cover-wrapper">
                                    @if ($book->cover)
                                        <img src="{{ asset('storage/' . $book->cover) }}" class="img-fluid book-cover"
                                            alt="cover {{ $book->title }}">
                                    @else
                                        <img src="https://via.placeholder.com/150x200?text=No+Image"
                                            class="img-fluid book-cover" alt="no cover">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <h5 class="card-title mb-1">{{ $book->title }}</h5>
                                        <p class="card-text mb-1 text-muted"><strong>Penulis:</strong> {{ $book->author }}
                                        </p>
                                        <p class="card-text mb-1 text-muted"><strong>Kategori:</strong>
                                            {{ $book->category->name ?? '-' }}</p>
                                        <p class="card-text mb-1 text-muted"><strong>Stok:</strong> {{ $book->stock }}</p>
                                    </div>

                                    <div class="mt-3 d-flex flex-wrap gap-2 align-items-center">
                                        <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-detail">
                                            Lihat Detail
                                        </a>

                                        @auth
                                            @if (auth()->user()->role === 'anggota' && $book->stock > 0)
                                                <label class="book-select-card">
                                                    <input type="checkbox" name="book_ids[]" value="{{ $book->id }}"
                                                        onchange="updateSelectedCount()" class="d-none toggle-check">
                                                    <div class="card-toggle">
                                                        <span class="checkmark">&#10003;</span> Pilih Buku
                                                    </div>
                                                </label>
                                            @endif

                                            @if (auth()->user()->role === 'admin')
                                                <a href="{{ route('books.edit', $book) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('books.destroy', $book) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info">Belum ada buku yang tersedia.</div>
                </div>
            @endforelse
        </div>

        {{-- Tombol Peminjaman Buku --}}
        @auth
            @if (auth()->user()->role === 'anggota')
                <div class="loan-action-floating">
                    <span id="selectedCount" class="text-muted small mb-2">0 buku dipilih</span>
                    <button type="submit" class="btn btn-success btn-sm shadow-sm px-3">
                        Ajukan Peminjaman
                    </button>
                </div>
                </form>
            @endif
        @endauth

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $books->links() }}
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function updateSelectedCount() {
            const count = document.querySelectorAll('input[name="book_ids[]"]:checked').length;
            document.getElementById('selectedCount').textContent = `${count} buku dipilih`;
        }
    </script>
@endpush

@push('styles')
    <style>
        .sticky-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .book-cover-wrapper {
            height: 200px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .book-cover {
            height: 100%;
            width: auto;
            object-fit: contain;
        }

        .btn-outline-secondary.detail-btn {
            font-weight: 500;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-outline-secondary.detail-btn:hover {
            background-color: #6c757d;
            color: #fff;
            transform: translateY(-1px);
        }

        .select-book-label {
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: #f8f9fa;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .select-book-label:hover {
            background-color: #e2e6ea;
            border-color: #adb5bd;
        }

        input[type="checkbox"] {
            cursor: pointer;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn {
            transition: all 0.2s ease-in-out;
        }

        .loan-action-floating {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: white;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            align-items: end;
            z-index: 1050;
        }

        .btn-detail {
            background-color: #e3f2fd;
            color: #0d47a1;
            font-weight: 500;
            border: 1px solid #bbdefb;
            transition: all 0.2s ease-in-out;
        }

        .btn-detail:hover {
            background-color: #bbdefb;
            color: #0b3c91;
        }

        /* Checkbox custom style saat memilih buku */
        input[type="checkbox"]:checked+span {
            background-color: #d0f0c0;
            border-color: #28a745;
            font-weight: bold;
            color: #155724;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
        }

        /* Hover effect untuk label "Pilih Buku" */
        .book-select-card {
            cursor: pointer;
            user-select: none;
        }

        .card-toggle {
            padding: 6px 12px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            display: inline-block;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            background-color: #f8f9fa;
            position: relative;
            color: #333;
        }

        .book-select-card:hover .card-toggle {
            border-color: #999;
            background-color: #e9ecef;
        }

        .card-toggle .checkmark {
            display: none;
            margin-right: 6px;
            font-weight: bold;
            color: #28a745;
        }

        .toggle-check:checked+.card-toggle {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
            font-weight: bold;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.2);
        }

        .toggle-check:checked+.card-toggle .checkmark {
            display: inline;
        }
    </style>
@endpush
