@extends('layouts.clean')

@section('title', 'Daftar Akun')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow-lg border-0 rounded-4 px-4 py-5"
            style="width: 100%; max-width: 500px; background-color: #ffffff;">
            <div class="text-center mb-4">
                <div class="mb-2">
                    <i class="bi bi-person-circle fs-1 text-primary"></i>
                </div>
                <h4 class="fw-bold text-dark">Daftar sebagai Anggota</h4>
            </div>

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success text-center py-2 small mb-3">
                    {{ session('success') }}
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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nama Anda"
                        required>
                    <label for="name">Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="nama@email.com"
                        required>
                    <label for="email">Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="08xxxxxxxxxx"
                        required>
                    <label for="phone">Nomor Telepon</label>
                </div>

                <div class="form-floating mb-3">
                    <textarea name="address" id="address" class="form-control" placeholder="Alamat lengkap" style="height: 100px;"
                        required></textarea>
                    <label for="address">Alamat</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                        required>
                    <label for="password">Password</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="Konfirmasi Password" required>
                    <label for="password_confirmation">Konfirmasi Password</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary fw-semibold shadow-sm">
                        <i class="bi bi-person-plus me-1"></i> Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="text-center mt-4 small">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-semibold">
                    Login di sini
                </a>
            </div>
        </div>
    </div>
@endsection
