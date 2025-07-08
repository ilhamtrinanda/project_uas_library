<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ilham_users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('ilham_users', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
};
