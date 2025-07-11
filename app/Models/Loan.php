<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Book;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'ilham_loans';

    protected $fillable = [
        'user_id',
        'processed_by',
        'loan_date',
        'return_date',
        'status',
    ];

    /**
     * Relasi ke user yang melakukan peminjaman
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke user yang memproses peminjaman (admin/petugas)
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Relasi ke daftar buku yang dipinjam
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'ilham_book_loan')
            ->withPivot('qty')
            ->withTimestamps();
    }
}
