<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========================
// Dashboard (beranda utama)
// ========================
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// ========================
// Auth Routes (Login, Register, Logout)
// ========================
// Halaman register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Proses register
Route::post('/register', [RegisterController::class, 'register']);
// Halaman sukses register
Route::get('/register/success', function () {
    return view('auth.registered');
})->middleware('auth')->name('register.success');

// Login
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

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// ========================
// Routes untuk user yang login
// ========================
Route::middleware(['auth'])->group(function () {
    // Users (admin only)
    Route::resource('users', UserController::class); // tabel: ilham_users

    // Categories
    Route::resource('categories', CategoryController::class); // tabel: ilham_categories

    // Books (CRUD penuh untuk admin/petugas)
    Route::resource('books', BookController::class)->except(['index', 'show']);

    // Loans
    Route::resource('loans', LoanController::class); // tabel: ilham_loans
    Route::post('/loans/request', [LoanController::class, 'requestLoan'])->name('loans.request');
    Route::post('/loans/request-multiple', [LoanController::class, 'requestMultiple'])->name('loans.requestMultiple');
    Route::patch('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::patch('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
    Route::post('/loans/{loan}/return', [LoanController::class, 'returnLoan'])->name('loans.return');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{bookId}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{bookId}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// ========================
// Route Publik (tanpa login)
// ========================
// Buku tetap bisa ditampilkan publik
Route::resource('books', BookController::class)->only(['index', 'show']);
