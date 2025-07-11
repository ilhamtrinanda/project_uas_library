<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tampilkan semua data peminjaman
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $search = $request->input('search');

        if ($user->role === 'anggota') {
            // Peminjaman milik user itu sendiri
            $loans = $user->loans()
                ->with(['books', 'processedBy'])
                ->when($search, function ($query, $search) {
                    $query->whereHas('books', function ($q) use ($search) {
                        $q->where('title', 'like', "%$search%")
                            ->orWhere('author', 'like', "%$search%");
                    });
                })
                ->orderByDesc('loan_date')
                ->get();
        } else {
            // Semua peminjaman
            $loans = \App\Models\Loan::with(['user', 'books', 'processedBy'])
                ->when($search, function ($query, $search) {
                    $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    })->orWhereHas('books', function ($q) use ($search) {
                        $q->where('title', 'like', "%$search%")
                            ->orWhere('author', 'like', "%$search%");
                    });
                })
                ->orderByDesc('loan_date')
                ->get();
        }

        return view('loans.index', compact('loans', 'search'));
    }

    // Form peminjaman baru
    public function create()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'petugas') {
            abort(403, 'Hanya admin atau petugas yang dapat mencatat peminjaman.');
        }

        $members = User::where('role', 'anggota')->get();
        $books = Book::where('stock', '>', 0)->get();

        return view('loans.create', compact('members', 'books'));
    }


    // Simpan data peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:ilham_users,id',
            'loan_date'   => 'required|date',
            'return_date' => 'required|date|after_or_equal:loan_date',
            'books'       => 'required|array|min:1',
            'books.*'     => 'exists:ilham_books,id',
        ]);

        $loan = Loan::create([
            'user_id'      => $request->user_id,
            'processed_by' => Auth::id(),
            'loan_date'    => $request->loan_date,
            'return_date'  => $request->return_date,
            'status'       => 'dipinjam',
        ]);

        // Tambahkan relasi buku
        foreach ($request->books as $bookId) {
            $loan->books()->attach($bookId, ['qty' => 1]);

            // Kurangi stok buku
            $book = Book::find($bookId);
            $book->decrement('stock');
        }

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil dicatat.');
    }


    // Form edit
    public function edit(Loan $loan)
    {
        return view('loans.edit', compact('loan'));
    }

    // Update data
    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'return_date' => 'required|date|after_or_equal:loan_date',
            'status'      => 'required|in:dipinjam,dikembalikan,telat',
        ]);

        $loan->update($request->only(['return_date', 'status']));

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    // Hapus data
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Peminjaman dihapus.');
    }

    public function requestLoan(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:ilham_books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock < 1) {
            return redirect()->back()->with('error', 'Stok buku habis.');
        }

        // Buat peminjaman
        $loan = Loan::create([
            'user_id'      => Auth::id(),
            'processed_by' => null, // karena belum disetujui
            'loan_date'    => now(),
            'return_date'  => now()->addDays(7),
            'status'       => 'menunggu', // ← BENAR, sedang menunggu persetujuan
        ]);


        $loan->books()->attach($book->id, ['qty' => 1]);

        return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil.');
    }

    public function approve(Loan $loan)
    {
        if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        foreach ($loan->books as $book) {
            // Pastikan stok cukup
            if ($book->stock < $book->pivot->qty) {
                return back()->with('error', 'Stok buku "' . $book->title . '" tidak mencukupi.');
            }
        }

        // Lanjutkan update status
        $loan->update([
            'status' => 'dipinjam',
            'processed_by' => Auth::id(),
        ]);

        // Kurangi stok
        foreach ($loan->books as $book) {
            $book->decrement('stock', $book->pivot->qty);
        }

        return back()->with('success', 'Peminjaman disetujui.');
    }


    public function reject(Loan $loan)
    {
        if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $loan->update([
            'status' => 'ditolak',
            'processed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function returnLoan(Loan $loan)
    {
        $user = Auth::user();

        // Jika anggota, hanya boleh mengembalikan pinjamannya sendiri
        if ($user->role === 'anggota' && $loan->user_id !== $user->id) {
            abort(403, 'Anda tidak bisa mengembalikan pinjaman orang lain.');
        }

        // Pastikan statusnya 'dipinjam'
        if ($loan->status !== 'dipinjam') {
            return back()->with('error', 'Peminjaman belum dalam status dipinjam.');
        }

        $loan->update([
            'status' => 'dikembalikan',
        ]);

        // Kembalikan stok buku
        foreach ($loan->books as $book) {
            $book->increment('stock', $book->pivot->qty);
        }

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }


    public function requestMultiple(Request $request)
    {
        $request->validate([
            'book_ids' => 'required|array|min:1',
            'book_ids.*' => 'exists:ilham_books,id',
        ]);

        $bookIds = $request->book_ids;

        // Buat data peminjaman
        $loan = Loan::create([
            'user_id' => Auth::id(),
            'processed_by' => null,
            'loan_date' => now(),
            'return_date' => now()->addDays(7),
            'status' => 'menunggu',
        ]);

        foreach ($bookIds as $bookId) {
            $loan->books()->attach($bookId, ['qty' => 1]);
        }

        return redirect()->route('books.index')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
}
