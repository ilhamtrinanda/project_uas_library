<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada kategori terlebih dahulu, agar category_id valid
        if (Category::count() === 0) {
            Category::factory()->count(5)->create();
        }

        // Buat 20 buku dummy
        Book::factory()->count(20)->create();
    }
}
    