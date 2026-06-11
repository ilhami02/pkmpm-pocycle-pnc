<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel riwayat scan pupuk organik cair.
     * Menyimpan data input (foto + suhu) dan hasil analisis AI.
     */
    public function up(): void
    {
        Schema::create('scan_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Data input pengguna
            $table->string('image_path');                        // Path foto galon (relative to storage)
            $table->decimal('temperature', 4, 1);                // Suhu (°C), misal 32.5

            // Hasil analisis dari AI
            $table->string('detected_color')->nullable();        // Warna terdeteksi: "coklat kehijauan", dll
            $table->enum('status', [
                'normal',           // ✅ Proses Normal
                'needs_stirring',   // ⚠️ Perlu Diaduk
                'contaminated',     // 🚫 Terkontaminasi
            ])->default('normal');
            $table->text('recommendation')->nullable();          // Langkah penanganan detail
            $table->json('ai_raw_response')->nullable();         // Raw response AI (untuk debugging)

            // Metadata
            $table->string('api_provider')->nullable();          // Provider API yang berhasil digunakan
            $table->timestamps();

            $table->index(['user_id', 'created_at']);             // Index untuk query riwayat per user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scan_histories');
    }
};
