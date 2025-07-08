<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        // Pakai gambar dummy yang disediakan (satu gambar saja, disalin banyak kali)
        $coverFilename = Str::uuid() . '.jpg';
        $dummyPath = storage_path('app/public/covers/dummy.jpg');
        $newPath = storage_path('app/public/covers/' . $coverFilename);
        copy($dummyPath, $newPath); // salin dummy.jpg sebagai file baru

        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'year' => $this->faker->numberBetween(2000, date('Y')),
            'isbn' => $this->faker->unique()->isbn13(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'stock' => $this->faker->numberBetween(1, 20),
            'cover' => 'covers/' . $coverFilename,
        ];
    }
}
