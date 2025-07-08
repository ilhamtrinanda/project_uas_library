<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ilham_loans', function (Blueprint $table) {
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'dipinjam', 'dikembalikan', 'telat'])
                ->default('menunggu')
                ->change();
        });
    }

    public function down(): void
    {
        //
    }
};
