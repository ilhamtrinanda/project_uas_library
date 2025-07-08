@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Detail Buku</h3>

        <div class="card mb-4 position-relative shadow-sm border-0">
            <div class="row g-0">
                {{-- Gambar Cover Buku --}}
                <div class="col-md-4">
                    @if ($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}"
                            class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="cover buku">
                    @else
                        <img src="https://via.placeholder.com/200x300?text=No+Image"
                            class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="no cover">
                    @endif
                </div>

                {{-- Detail Buku --}}
                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title mb-3">{{ $book->title }}</h4>

                        <table class="table table-borderless table-sm mb-4">
                            <tr>
                                <th class="text-muted" width="30%">Penulis</th>
                                <td>{{ $book->author }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Penerbit</th>
                                <td>{{ $book->publisher }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tahun Terbit</th>
                                <td>{{ $book->year }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">ISBN</th>
                                <td>{{ $book->isbn }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Kategori</th>
                                <td>{{ $book->category->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Stok</th>
                                <td>{{ $book->stock }}</td>
                            </tr>
                        </table>

                        @auth
                            @php
                                $isFavorite = \App\Models\Favorite::where('user_id', auth()->id())
                                    ->where('book_id', $book->id)
                                    ->exists();
                            @endphp

                            <div class="d-flex flex-wrap gap-2 mb-4">
                                {{-- Tombol Favorit --}}
                                @if ($isFavorite)
                                    <form action="{{ route('favorites.destroy', $book->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger">Hapus dari Favorit</button>
                                    </form>
                                @else
                                    <form action="{{ route('favorites.store', $book->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-outline-primary">Tambah ke Favorit</button>
                                    </form>
                                @endif

                                {{-- Tombol Edit --}}
                                <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">Edit</a>
                            </div>
                        @endauth

                        {{-- Tombol Kembali --}}
                        @php
                            $backRoute = route('books.index');
                            if (request('from') === 'favorites') {
                                $backRoute = route('favorites.index');
                            } elseif (request('from') === 'dashboard') {
                                $backRoute = route('dashboard');
                            }
                        @endphp
                        <a href="{{ $backRoute }}" class="text-decoration-none fw-semibold text-primary"
                            style="position: absolute; bottom: 16px; right: 16px; font-size: 0.9rem;">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
