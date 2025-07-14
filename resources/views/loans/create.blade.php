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
                <label class="form-label fw-semibold">Pilih Buku</label>
                <div class="row row-cols-1 row-cols-md-2 g-2">
                    @forelse ($books as $book)
                        <div class="col">
                            <label class="border rounded p-3 d-flex gap-2 align-items-start bg-light h-100">
                                <input type="checkbox" name="books[]" value="{{ $book->id }}"
                                    class="form-check-input mt-1">
                                <div class="small">
                                    <div class="fw-semibold text-truncate">{{ $book->title }}</div>
                                    <div class="text-muted">
                                        <small>Penulis: {{ $book->author }}</small><br>
                                        <small>Stok: {{ $book->stock }}</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @empty
                        <div class="col">
                            <div class="p-3 text-muted text-center border rounded">Tidak ada buku tersedia.</div>
                        </div>
                    @endforelse
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
