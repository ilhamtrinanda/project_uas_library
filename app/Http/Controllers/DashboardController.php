<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search'); // ambil keyword dari query string (?search=...)

        $books = Book::all();

        // Pencarian pada buku terbaru
        $latestBooksQuery = Book::latest();
        if ($search) {
            $latestBooksQuery->where('title', 'like', '%' . $search . '%');
        }
        $latestBooks = $latestBooksQuery->get();

        $loans = Loan::with('books', 'user')
            ->where('status', 'dipinjam')
            ->latest()
            ->take(5)
            ->get();

        $totalLoanedBooks = $loans->reduce(function ($carry, $loan) {
            return $carry + $loan->books->sum(fn($book) => $book->pivot->qty);
        }, 0);

        return view('dashboard.index', compact('books', 'latestBooks', 'loans', 'totalLoanedBooks'));
    }
}
