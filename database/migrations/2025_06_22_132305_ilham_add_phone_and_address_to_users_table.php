<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ilham_users', function (Blueprint $table) {
            if (!Schema::hasColumn('ilham_users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('ilham_users', 'address')) {
                $table->string('address')->nullable()->after('phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ilham_users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address']);
        });
    }
};
