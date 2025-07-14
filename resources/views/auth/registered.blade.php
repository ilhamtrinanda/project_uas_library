@extends('layouts.clean')

@section('title', 'Pendaftaran Berhasil')

@section('content')
    <div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center" style="max-width: 480px; width: 100%;">
            <h4 class="fw-bold mb-3">Pendaftaran Berhasil</h4>
            <p class="mb-1">Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</p>
            <p class="text-muted mb-4">Akun kamu telah berhasil dibuat dan kamu sudah masuk ke sistem.</p>

            <a href="{{ route('dashboard') }}" class="btn btn-primary w-100 fw-semibold">Masuk ke Halaman Home</a>
        </div>
    </div>
@endsection
