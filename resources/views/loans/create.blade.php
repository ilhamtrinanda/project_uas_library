@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Form Peminjaman Buku</h2>

    <form action="{{ route('loans.store') }}" method="POST">
        @csrf

        <!-- Pilih Anggota -->
        <div class="mb-3">
            <label for="user_id" class="form-label">Anggota</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Pilih Anggota --</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
            @error('user_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Pilih Buku -->
        <div class="mb-3">
            <label class="form-label">Pilih Buku</label>
            <div class="border rounded p-3">
                @foreach ($books as $book)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="books[]" value="{{ $book->id }}"
                            id="book{{ $book->id }}">
                        <label class="form-check-label" for="book{{ $book->id }}">
                            {{ $book->title }} (Stok: {{ $book->stock }})
                        </label>
                    </div>
                @endforeach
            </div>
            @error('books')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Tanggal Pinjam -->
        <div class="mb-3">
            <label for="loan_date" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="loan_date" class="form-control" required>
            @error('loan_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Tanggal Kembali -->
        <div class="mb-3">
            <label for="return_date" class="form-label">Tanggal Kembali</label>
            <input type="date" name="return_date" class="form-control" required>
            @error('return_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('loans.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
