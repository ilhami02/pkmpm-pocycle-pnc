<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scan_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('fermentation_batch_id')->nullable()->after('user_id');
            
            $table->foreign('fermentation_batch_id')
                  ->references('id')
                  ->on('fermentation_batches')
                  ->nullOnDelete();
                  
            $table->index('fermentation_batch_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scan_histories', function (Blueprint $table) {
            $table->dropForeign(['fermentation_batch_id']);
            $table->dropColumn('fermentation_batch_id');
        });
    }
};
