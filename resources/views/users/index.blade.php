@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-white border-bottom-0 rounded-top-4 px-4 py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0 fw-bold">Daftar Pengguna</h4>

                    <form action="{{ route('users.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control form-control-sm me-2" placeholder="Cari nama/email...">
                        <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                    </form>

                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-success fw-semibold">Tambah Pengguna</a>
                </div>
            </div>

            <div class="card-body p-4">
                @if (session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle small text-center">
                        <thead class="table-light">
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
                            @forelse ($users as $user)
                                <tr>
                                    <td class="text-start">{{ $user->name }}</td>
                                    <td class="text-start">{{ $user->email }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill px-3 py-1 text-capitalize fw-semibold
                                            @if ($user->role === 'admin') bg-primary-subtle text-primary
                                            @elseif($user->role === 'petugas') bg-info-subtle text-info
                                            @else bg-secondary-subtle text-secondary @endif">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->phone }}</td>
                                    <td class="text-start">{{ $user->address }}</td>
                                    <td>
                                        @if (in_array(auth()->user()->role, ['admin', 'petugas']))
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm"
                                                style="background-color: #3F51B5; color: white;">Edit</a>

                                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        @else
                                            <span class="text-muted small">Tidak tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data pengguna.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
