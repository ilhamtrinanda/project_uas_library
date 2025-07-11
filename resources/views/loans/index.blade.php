@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-white border-bottom-0 rounded-top-4 px-4 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">Daftar Peminjaman</h4>
                    <a href="{{ route('loans.create') }}" class="btn btn-primary btn-sm fw-semibold">Tambah Peminjaman</a>
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
                                <th>Anggota</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th>Daftar Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($loans as $loan)
                                @php
                                    $isLate = $loan->status === 'dipinjam' && now()->gt($loan->return_date);
                                @endphp
                                <tr>
                                    <td>{{ $loan->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($loan->return_date)->format('d M Y') }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill px-3 py-1 text-capitalize fw-semibold
                                            @if ($isLate) text-danger bg-danger-subtle
                                            @elseif ($loan->status === 'dipinjam')
                                                text-warning bg-warning-subtle
                                            @elseif ($loan->status === 'dikembalikan')
                                                text-success bg-success-subtle
                                            @elseif ($loan->status === 'ditolak')
                                                text-dark bg-dark-subtle
                                            @elseif ($loan->status === 'menunggu')
                                                text-secondary bg-secondary-subtle
                                            @else
                                                text-info bg-info-subtle @endif">
                                            {{ $isLate ? 'Telat' : ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $loan->processedBy->name ?? '-' }}</td>
                                    <td class="text-start">
                                        <ul class="ps-3 mb-0">
                                            @forelse ($loan->books as $book)
                                                <li>{{ $book->title }}</li>
                                            @empty
                                                <li><em>Tidak ada buku</em></li>
                                            @endforelse
                                        </ul>
                                    </td>
                                    <td class="text-center">
                                        @if (in_array(auth()->user()->role, ['admin', 'petugas']))
                                            @if ($loan->status === 'menunggu')
                                                <form action="{{ route('loans.approve', $loan->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm"
                                                        style="background-color: #3F51B5; color: white;">Setujui</button>
                                                </form>
                                                <form action="{{ route('loans.reject', $loan->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm text-white"
                                                        style="background-color: #B0BEC5;">Tolak</button>
                                                </form>
                                            @endif

                                            @if ($loan->status === 'dipinjam')
                                                <form action="{{ route('loans.return', $loan->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin buku sudah dikembalikan?')"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm"
                                                        style="background-color: #3fb570; color: white;">Kembalikan</button>
                                                </form>
                                            @endif

                                            <a href="{{ route('loans.edit', $loan) }}" class="btn btn-sm"
                                                style="background-color: #3F51B5; color: white;">Edit</a>

                                            <form action="{{ route('loans.destroy', $loan) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        @else
                                            @if ($loan->status === 'dipinjam' && $loan->user_id === auth()->id())
                                                <form action="{{ route('loans.return', $loan->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm"
                                                        style="background-color: #3F51B5; color: white;">Kembalikan</button>
                                                </form>
                                            @else
                                                <span class="text-muted small">Tidak tersedia</span>
                                            @endif
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
        </div>
    </div>
@endsection
