@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Pengguna</h3>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        @include('users.form', ['button' => 'Update'])

    </form>
</div>
@endsection
