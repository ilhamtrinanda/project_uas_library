@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4 fw-bold">Tambah Pengguna</h3>

        @if ($errors->any())
            <div class="alert alert-danger border-start border-4 border-danger-subtle shadow-sm rounded-3">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 mt-3">
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    @include('users.form', ['button' => 'Simpan'])

                </form>
            </div>
        </div>
    </div>
@endsection
