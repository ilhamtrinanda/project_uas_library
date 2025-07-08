<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::all();
        $latestBooks = Book::latest()->take(10)->get(); // ambil 10 buku terbaru

        // ambil loans yang masih aktif (dipinjam)
        $loans = Loan::with('books', 'user')
            ->where('status', 'dipinjam')
            ->latest()
            ->take(5)
            ->get();

        // Hitung total buku dipinjam (dari relasi pivot qty)
        $totalLoanedBooks = $loans->reduce(function ($carry, $loan) {
            return $carry + $loan->books->sum(fn($book) => $book->pivot->qty);
        }, 0);

        return view('dashboard.index', compact('books', 'latestBooks', 'loans', 'totalLoanedBooks'));
    }
}
