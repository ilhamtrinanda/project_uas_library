<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ilham_books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->year('year');
            $table->string('isbn')->unique();
            $table->foreignId('category_id')
                ->constrained('ilham_categories')
                ->onDelete('cascade');
            $table->integer('stock')->default(0);
            $table->string('cover')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ilham_books');
    }
};
