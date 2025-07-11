<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Anda belum login.');
        }

        if (Auth::user()->role === 'anggota') {
            abort(403, 'Anggota tidak boleh melihat daftar pengguna.');
        }

        $query = User::query();

        // Fitur pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Urutan berdasarkan role: admin → petugas → anggota
        $query->orderByRaw("FIELD(role, 'admin', 'petugas', 'anggota')");

        $users = $query->latest()->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::check()) {
            abort(403, 'Anda belum login.');
        }

        if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('users.create'); // gunakan view/users/create.blade.php
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'petugas'])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:ilham_users,email',
            'password' => 'required|min:3|confirmed',
            'role'     => 'required|in:admin,petugas,anggota',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'phone'    => $request->phone,
            'address'  => $request->address,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa mengedit.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa mengubah data pengguna.');
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:ilham_users,email,' . $user->id,
            'role'  => 'required|in:admin,petugas,anggota',
        ]);

        $user->update($request->only(['name', 'email', 'role', 'phone', 'address']));

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa menghapus pengguna.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
