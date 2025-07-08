<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Auth Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', fn() => redirect('/'))->name('login');
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->with('error', 'Email atau password salah.');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Resource routes (dilindungi login)
Route::middleware(['auth'])->group(function () {
    // Resource route tetap menggunakan nama logis (tanpa ilham_)
    Route::resource('users', UserController::class);        // model pakai 'ilham_users'
    Route::resource('categories', CategoryController::class); // model pakai 'ilham_categories'
    Route::resource('books', BookController::class);        // model pakai 'ilham_books'
    Route::resource('loans', LoanController::class);        // model pakai 'ilham_loans'

    // Tambahan peminjaman
    Route::post('/loans/request', [LoanController::class, 'requestLoan'])->name('loans.request');
    Route::patch('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::patch('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
    Route::put('/loans/{loan}/return', [LoanController::class, 'returnLoan'])->name('loans.return');
    Route::post('/loans/request-multiple', [App\Http\Controllers\LoanController::class, 'requestMultiple'])->name('loans.requestMultiple');
});

// Route publik, tidak perlu login
Route::resource('books', BookController::class)->only(['index', 'show']);

// Route yang butuh login (hanya untuk tambah/edit/hapus)
Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class)->except(['index', 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{bookId}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{bookId}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
