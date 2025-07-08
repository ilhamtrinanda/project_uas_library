<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('storage/covers/' . $this->photo)
            : asset('storage/covers/default-profile.jpg');
    }


    // Relasi lainnya
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function processedLoans()
    {
        return $this->hasMany(Loan::class, 'processed_by');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
