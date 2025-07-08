<div class="mb-3">
    <label for="name">Nama</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>

@if (!isset($user))
    {{-- hanya saat create --}}
    <div class="mb-3">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
@endif


<div class="mb-3">
    <label for="role">Role</label>
    <select name="role" class="form-select" required>
        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="petugas" {{ old('role', $user->role ?? '') == 'petugas' ? 'selected' : '' }}>Petugas</option>
        <option value="anggota" {{ old('role', $user->role ?? '') == 'anggota' ? 'selected' : '' }}>Anggota</option>
    </select>
</div>

<div class="mb-3">
    <label for="phone">Telepon</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
</div>

<div class="mb-3">
    <label for="address">Alamat</label>
    <textarea name="address" class="form-control">{{ old('address', $user->address ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-success">{{ $button }}</button>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
