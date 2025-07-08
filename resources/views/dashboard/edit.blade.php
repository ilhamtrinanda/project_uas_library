@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="mb-3">Edit Profil Saya</h4>

        @if (session('success'))
            <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Foto Profil</label><br>
                <img src="{{ auth()->user()->photo_url }}" alt="Foto Profil" width="60" class="rounded-circle mb-2">
                <input type="file" name="photo" class="form-control">
                <small class="text-muted">Boleh dikosongkan jika tidak ingin mengganti foto.</small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
@endsection
