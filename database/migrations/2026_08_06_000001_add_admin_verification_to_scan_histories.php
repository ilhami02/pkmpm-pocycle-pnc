<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom verifikasi admin pada tabel scan_histories.
     * Memungkinkan admin meng-override status AI dan memberikan catatan.
     */
    public function up(): void
    {
        Schema::table('scan_histories', function (Blueprint $table) {
            $table->enum('admin_status', ['normal', 'needs_stirring', 'contaminated'])
                  ->nullable()
                  ->after('api_provider');
            $table->text('admin_note')->nullable()->after('admin_status');
            $table->timestamp('verified_at')->nullable()->after('admin_note');
            $table->foreignId('verified_by')->nullable()->after('verified_at')
                  ->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scan_histories', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['admin_status', 'admin_note', 'verified_at', 'verified_by']);
        });
    }
};
