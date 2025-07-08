@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Daftar Peminjaman</h2>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('loans.create') }}" class="btn btn-primary mb-3">+ Tambah Peminjaman</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Diproses Oleh</th>
                        <th>Daftar Buku</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr>
                            <td>{{ $loan->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->return_date)->format('d M Y') }}</td>
                            <td>
                                <span
                                    class="badge
                                    @if ($loan->status === 'dipinjam') bg-warning
                                    @elseif($loan->status === 'dikembalikan') bg-success
                                    @elseif($loan->status === 'ditolak') bg-danger
                                    @elseif($loan->status === 'menunggu') bg-secondary
                                    @else bg-info @endif">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td>{{ $loan->processedBy->name ?? '-' }}</td>

                            <td>
                                <ul class="mb-0 ps-3">
                                    @forelse ($loan->books as $book)
                                        <li>{{ $book->title }}</li>
                                    @empty
                                        <li><em>Tidak ada buku</em></li>
                                    @endforelse
                                </ul>
                            </td>

                            <td>
                                @if (in_array(auth()->user()->role, ['admin', 'petugas']))
                                    @if ($loan->status === 'menunggu')
                                        <form action="{{ route('loans.approve', $loan->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success mb-1">Setujui</button>
                                        </form>

                                        <form action="{{ route('loans.reject', $loan->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-secondary mb-1">Tolak</button>
                                        </form>
                                    @endif

                                    @if ($loan->status === 'dipinjam')
                                        <form action="{{ route('loans.return', $loan->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin buku sudah dikembalikan?')" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-success mb-1">Kembalikan</button>
                                        </form>
                                    @endif

                                    <a href="{{ route('loans.edit', $loan) }}" class="btn btn-sm btn-warning mb-1">Edit</a>

                                    <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mb-1">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
