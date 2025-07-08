<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    // Relasi: peminjam
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: petugas yang memproses
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Relasi opsional: jika pakai pivot untuk banyak buku
    public function books()
    {
        return $this->belongsToMany(Book::class, 'ilham_book_loan')
            ->withPivot('qty')
            ->withTimestamps();
    }
}
