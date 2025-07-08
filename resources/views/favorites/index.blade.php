@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Buku Favorit Saya</h3>

        <div class="row">
            {{-- Kolom Buku Favorit --}}
            <div class="col-lg-8">
                @if ($favorites->isEmpty())
                    <div class="alert alert-info">Kamu belum menambahkan buku ke favorit.</div>
                @else
                    <div class="scrollable-favorites pe-2">
                        <div class="row g-3">
                            @foreach ($favorites as $favorite)
                                <div class="col-md-6">
                                    <div class="card h-100 shadow-sm d-flex flex-row align-items-start">
                                        <div class="p-2">
                                            @if ($favorite->book->cover)
                                                <img src="{{ asset('storage/' . $favorite->book->cover) }}" class="rounded"
                                                    width="100" height="150" alt="cover buku">
                                            @else
                                                <img src="https://via.placeholder.com/100x150?text=No+Image" class="rounded"
                                                    alt="no cover">
                                            @endif
                                        </div>
                                        <div class="card-body p-2 d-flex flex-column justify-content-between">
                                            <div>
                                                <h6 class="card-title mb-1">{{ $favorite->book->title }}</h6>
                                                <small class="text-muted d-block mb-1">Penulis:
                                                    {{ $favorite->book->author }}</small>
                                                <small class="text-muted d-block">Penerbit:
                                                    {{ $favorite->book->publisher }}</small>
                                            </div>
                                            <div class="d-flex gap-2 mt-2">
                                                <a href="{{ route('books.show', $favorite->book->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Detail</a>
                                                <form action="{{ route('favorites.destroy', $favorite->book->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Kolom Buku Terbaru --}}
            <div class="col-lg-4 mt-4 mt-lg-0">
                <h5 class="mb-3">Buku Terbaru</h5>
                <div class="list-group small">
                    @foreach ($latestBooks as $book)
                        <a href="{{ route('books.show', $book) }}?from=favorites"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                            <div class="me-auto">
                                <div class="fw-semibold">{{ $book->title }}</div>
                                <small class="text-muted">{{ $book->author }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
