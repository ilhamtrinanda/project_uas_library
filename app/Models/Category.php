<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'ilham_categories';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'name',
        'description',
    ];

    // Relasi: satu kategori punya banyak buku
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id', 'id');
    }
}
