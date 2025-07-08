<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $table = 'ilham_books';

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'isbn',
        'category_id',
        'stock',
        'cover'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    public function loans()
    {
        return $this->belongsToMany(Loan::class, 'ilham_book_loan')
            ->withPivot('qty')
            ->withTimestamps();
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
