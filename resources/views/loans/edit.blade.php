@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Peminjaman</h2>

    <form action="{{ route('loans.update', $loan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="return_date" class="form-label">Tanggal Kembali</label>
            <input type="date" name="return_date" class="form-control" value="{{ $loan->return_date }}" required>
            @error('return_date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="dipinjam" {{ $loan->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="dikembalikan" {{ $loan->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                <option value="telat" {{ $loan->status == 'telat' ? 'selected' : '' }}>Telat</option>
            </select>
            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('loans.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
