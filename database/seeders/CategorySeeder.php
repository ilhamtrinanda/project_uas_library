<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Novel', 'description' => 'Kumpulan novel berbagai genre'],
            ['name' => 'Fiksi', 'description' => 'Novel, cerita pendek, dll.'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku sejarah, biografi, dll.'],
            ['name' => 'Teknologi', 'description' => 'IT, komputer, dan teknologi lainnya'],
            ['name' => 'Pendidikan', 'description' => 'Buku pelajaran, referensi, dll.'],
            ['name' => 'Agama', 'description' => 'Buku keagamaan dan spiritual'],
            ['name' => 'Filsafat', 'description' => 'Buku-buku filsafat dan pemikiran kritis'],
            ['name' => 'Sains', 'description' => 'Buku-buku ilmiah dan pengetahuan umum'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
