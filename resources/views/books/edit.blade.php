@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4 fw-bold">Edit Data Buku</h3>

        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div class="mb-3">
                <label for="title" class="form-label">Judul Buku</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $book->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Penulis --}}
            <div class="mb-3">
                <label for="author" class="form-label">Penulis</label>
                <input type="text" name="author" class="form-control @error('author') is-invalid @enderror"
                    value="{{ old('author', $book->author) }}" required>
                @error('author')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Penerbit --}}
            <div class="mb-3">
                <label for="publisher" class="form-label">Penerbit</label>
                <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror"
                    value="{{ old('publisher', $book->publisher) }}" required>
                @error('publisher')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tahun Terbit --}}
            <div class="mb-3">
                <label for="year" class="form-label">Tahun Terbit</label>
                <input type="number" name="year" class="form-control @error('year') is-invalid @enderror"
                    value="{{ old('year', $book->year) }}" required min="1900" max="{{ date('Y') }}">
                @error('year')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ISBN --}}
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror"
                    value="{{ old('isbn', $book->isbn) }}" required>
                @error('isbn')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kategori --}}
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Stok --}}
            <div class="mb-3">
                <label for="stock" class="form-label">Stok</label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                    value="{{ old('stock', $book->stock) }}" required min="0">
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Cover --}}
            <div class="mb-3">
                <label for="cover" class="form-label">Ganti Cover (opsional)</label>
                <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror"
                    accept="image/*">
                @error('cover')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($book->cover)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="cover lama" class="img-thumbnail"
                            width="120">
                        <p class="text-muted mb-0 mt-1"><small>Cover lama saat ini</small></p>
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
