@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 600px;">
        <h4 class="mb-4 fw-semibold text-center">Edit Profil Saya</h4>

        @if (session('success'))
            <div class="alert alert-success small">{{ session('success') }}</div>
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
            class="shadow-sm p-4 bg-white rounded-4">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label fw-semibold">Foto Profil</label><br>
                <img src="{{ $user->photo_url }}" alt="Foto Profil" width="70" class="rounded-circle mb-2 shadow-sm">
                <input type="file" name="photo" class="form-control">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti.</small>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password Baru</label>
                <input type="password" name="password" class="form-control"
                    placeholder="Biarkan kosong jika tidak ingin mengganti">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
