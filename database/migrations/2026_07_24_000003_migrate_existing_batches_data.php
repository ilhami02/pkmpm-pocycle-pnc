<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $users = DB::table('users')->whereNotNull('current_batch_started_at')->get();

        foreach ($users as $user) {
            $batchId = DB::table('fermentation_batches')->insertGetId([
                'user_id' => $user->id,
                'name' => 'Galon 1',
                'started_at' => $user->current_batch_started_at,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('scan_histories')
                ->where('user_id', $user->id)
                ->whereNull('fermentation_batch_id')
                ->update(['fermentation_batch_id' => $batchId]);
        }

        DB::table('users')->update(['current_batch_started_at' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $batches = DB::table('fermentation_batches')->where('status', 'active')->get();

        foreach ($batches as $batch) {
            DB::table('users')
                ->where('id', $batch->user_id)
                ->update(['current_batch_started_at' => $batch->started_at]);
        }

        DB::table('scan_histories')->update(['fermentation_batch_id' => null]);
        DB::table('fermentation_batches')->delete();
    }
};
