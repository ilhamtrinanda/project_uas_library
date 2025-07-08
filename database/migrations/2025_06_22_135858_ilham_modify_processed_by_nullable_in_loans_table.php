<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ilham_loans', function (Blueprint $table) {
            $table->unsignedBigInteger('processed_by')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ilham_loans', function (Blueprint $table) {
            //
        });
    }
};
