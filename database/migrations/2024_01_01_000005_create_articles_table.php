<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel artikel edukasi tentang pembuatan pupuk organik cair.
     * Konten dikelola secara manual oleh admin.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();                 // Ringkasan singkat untuk preview
            $table->longText('body');                            // Konten artikel (HTML)
            $table->string('cover_image')->nullable();           // Path gambar sampul
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
