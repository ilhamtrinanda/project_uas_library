<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Loan;
use App\Models\Favorite;


/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Loan[] $loans
 * @method \Illuminate\Database\Eloquent\Relations\HasMany loans()
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'ilham_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mengambil URL foto profil.
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('storage/covers/' . $this->photo)
            : asset('storage/covers/default-profile.jpg');
    }

    /**
     * Relasi: Memiliki banyak peminjaman (loans) oleh user.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class, 'user_id');
    }

    /**
     * Relasi: Memiliki banyak peminjaman yang diproses oleh user (misalnya admin/petugas).
     */
    public function processedLoans()
    {
        return $this->hasMany(Loan::class, 'processed_by');
    }

    /**
     * Relasi: Favorit buku.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
