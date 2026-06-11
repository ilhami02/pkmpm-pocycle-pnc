<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel untuk menyimpan daftar API token dengan dukungan fallback.
     * Token dienkripsi di Model layer menggunakan Laravel's encrypt/decrypt.
     */
    public function up(): void
    {
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('provider');                          // Nama provider: 'gemini', 'openai', dll
            $table->text('token');                               // API key (encrypted via Model Attribute)
            $table->unsignedInteger('priority')->default(0);     // Urutan: 0 = paling prioritas
            $table->boolean('is_active')->default(true);         // Toggle aktif/non-aktif
            $table->timestamp('last_used_at')->nullable();       // Terakhir digunakan
            $table->timestamp('rate_limited_until')->nullable(); // Skip token sampai waktu ini
            $table->unsignedInteger('usage_count')->default(0);  // Total penggunaan
            $table->timestamps();

            $table->index(['is_active', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_tokens');
    }
};
