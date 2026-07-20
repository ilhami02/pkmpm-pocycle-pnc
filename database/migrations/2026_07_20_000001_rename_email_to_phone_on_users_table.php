<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mengubah kolom email menjadi phone pada tabel users.
     * Autentikasi kini menggunakan nomor HP, bukan email.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('email', 'phone');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('phone', 'email');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable()->after('phone');
        });
    }
};
