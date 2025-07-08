<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Tampilkan daftar buku favorit user yang sedang login
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->with('book')
            ->latest()
            ->get();

        $latestBooks = \App\Models\Book::latest()->get();

        return view('favorites.index', compact('favorites', 'latestBooks'));
    }


    // Tambah buku ke favorit
    public function store($bookId)
    {
        $exists = Favorite::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->exists();

        if (!$exists) {
            Favorite::create([
                'user_id' => Auth::id(),
                'book_id' => $bookId,
            ]);
        }

        // Alihkan langsung ke halaman favorit
        return redirect()->route('favorites.index')->with('success', 'Buku ditambahkan ke favorit!');
    }


    // Hapus buku dari favorit
    public function destroy($bookId)
    {
        Favorite::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->delete();

        return back()->with('success', 'Buku dihapus dari favorit!');
    }
}
