<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ilham_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('ilham_users')->onDelete('cascade');
            $table->foreignId('processed_by')->nullable()->constrained('ilham_users')->onDelete('set null');
            $table->date('loan_date');
            $table->date('return_date');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'dipinjam', 'dikembalikan', 'telat'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ilham_loans');
    }
};
