@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Tambah Pengguna</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            @include('users.form', ['button' => 'Simpan'])

        </form>
    </div>
@endsection
