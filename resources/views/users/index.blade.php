@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Daftar Pengguna</h3>

        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>
                            {{-- Tombol tetap muncul untuk admin dan petugas --}}
                            @if (in_array(auth()->user()->role, ['admin', 'petugas']))
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
