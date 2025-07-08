@extends('layouts.app')

@section('content')
<div class="container">
    <h3>📘 Tambah Buku</h3>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Judul Buku --}}
        <div class="mb-3">
            <label for="title" class="form-label">Judul Buku</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title') }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Penulis --}}
        <div class="mb-3">
            <label for="author" class="form-label">Penulis</label>
            <input type="text" name="author" class="form-control @error('author') is-invalid @enderror"
                   value="{{ old('author') }}" required>
            @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Penerbit --}}
        <div class="mb-3">
            <label for="publisher" class="form-label">Penerbit</label>
            <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror"
                   value="{{ old('publisher') }}" required>
            @error('publisher') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Tahun Terbit --}}
        <div class="mb-3">
            <label for="year" class="form-label">Tahun Terbit</label>
            <input type="number" name="year" class="form-control @error('year') is-invalid @enderror"
                   value="{{ old('year') }}" required min="1900" max="{{ date('Y') }}">
            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- ISBN --}}
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror"
                   value="{{ old('isbn') }}" required>
            @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Stok --}}
        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                   value="{{ old('stock') }}" required min="0">
            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Cover --}}
        <div class="mb-3">
            <label for="cover" class="form-label">Cover Buku (gambar)</label>
            <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
            @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
