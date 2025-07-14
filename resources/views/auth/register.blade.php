@extends('layouts.clean')

@section('title', 'Daftar Akun')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow-sm border-0 rounded-4 p-4" style="width: 100%; max-width: 480px;">
            <h4 class="fw-bold text-center mb-4">Form Pendaftaran</h4>

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success text-center small mb-3">
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
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nama Lengkap"
                        required>
                    <label for="name">Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                    <label for="email">Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Nomor Telepon"
                        required>
                    <label for="phone">Nomor Telepon</label>
                </div>

                <div class="form-floating mb-3">
                    <textarea name="address" id="address" class="form-control" placeholder="Alamat Lengkap" style="height: 100px;"
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
                    <button type="submit" class="btn btn-primary fw-semibold">
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="text-center mt-4 small">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                    Login di sini
                </a>
            </div>
        </div>
    </div>
@endsection
