<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ilham_book_loan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('ilham_loans')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('ilham_books')->onDelete('cascade');
            $table->integer('qty')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ilham_book_loan');
    }
};
