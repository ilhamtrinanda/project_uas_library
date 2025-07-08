<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->latest()->paginate(15);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }


        $categories = Category::all();
        return view('books.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'publisher'   => 'required|string|max:255',
            'year'        => 'required|numeric|min:1900|max:' . date('Y'),
            'isbn'        => 'required|string|unique:ilham_books',
            'category_id' => 'required|exists:ilham_categories,id',
            'stock'       => 'required|numeric|min:0',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload file cover jika ada
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // Simpan buku
        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        if (!Auth::check()) {
            abort(403, 'Anda belum login.');
        }

        if (Auth::user()->role === 'anggota') {
            abort(403, 'Anggota tidak boleh mengedit buku.');
        }

        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        if (!Auth::check()) {
            abort(403, 'Anda belum login.');
        }

        if (Auth::user()->role === 'anggota') {
            abort(403, 'Anggota tidak boleh mengedit buku.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'publisher'   => 'required|string|max:255',
            'year'        => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'isbn'        => 'required|string|unique:ilham_books,isbn,' . $book->id,
            'category_id' => 'required|exists:ilham_categories,id',
            'stock'       => 'required|integer|min:0',
            'cover'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            $coverPath = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = $coverPath;
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }


    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }


    public function destroy(Book $book)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang boleh menghapus buku.');
        }

        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
