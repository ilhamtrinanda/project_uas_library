@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 600px;">
        <h4 class="mb-4 fw-bold text-center">Edit Profil</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show small" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
            class="p-4 bg-white rounded-4 shadow-sm border">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Foto Profil --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Foto Profil</label><br>
                <img src="{{ $user->photo_url }}" alt="Foto Profil" width="80" class="rounded-circle mb-2 shadow-sm">
                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password Baru</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Kosongkan jika tidak ingin mengubah">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>

            {{-- Tombol Submit --}}
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
