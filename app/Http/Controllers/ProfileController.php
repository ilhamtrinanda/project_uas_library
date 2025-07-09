<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:ilham_users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists('covers/' . $user->photo)) {
                Storage::disk('public')->delete('covers/' . $user->photo);
            }

            $file = $request->file('photo');
            $filename = 'ilham_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('covers', $filename, 'public');

            $user->photo = $filename;
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // ⬇⬇ Ubah dari redirect()->back() ke dashboard
        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
