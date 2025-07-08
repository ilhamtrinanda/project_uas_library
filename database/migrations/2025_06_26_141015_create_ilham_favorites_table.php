<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ilham_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('ilham_users')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('ilham_books')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ilham_favorites');
    }
};
