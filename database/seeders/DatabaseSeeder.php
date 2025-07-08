<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Admin Perpus',
            'email'    => 'admin@perpus.test',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::factory()->count(2)->create([
            'role' => 'petugas',
        ]);

        User::factory()->count(5)->create([
            'role' => 'anggota',
        ]);

        $this->call([
            CategorySeeder::class,
        ]);

        $this->call([
            BookSeeder::class,
        ]);

        echo "✅ Seeder selesai dijalankan.\n";
    }
}
