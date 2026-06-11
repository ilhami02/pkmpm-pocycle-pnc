<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\FertilizerCheckReminder;
use Illuminate\Console\Command;

/**
 * Command untuk mengirim reminder berkala ke pengguna.
 * Dijalankan via Task Scheduler setiap 3 hari.
 *
 * Usage: php artisan pocycle:send-reminders
 */
class SendFertilizerReminders extends Command
{
    protected $signature = 'pocycle:send-reminders';

    protected $description = 'Kirim reminder berkala untuk mengecek galon POC kepada semua pengguna yang mengaktifkan reminder';

    public function handle(): int
    {
        $this->info('🌿 Memulai pengiriman reminder POCYCLE...');

        $users = User::where('reminder_enabled', true)->get();

        if ($users->isEmpty()) {
            $this->warn('Tidak ada pengguna dengan reminder aktif.');
            return Command::SUCCESS;
        }

        $sent = 0;
        $skipped = 0;

        foreach ($users as $user) {
            $lastScan = $user->scanHistories()->latest()->first();

            // Kirim reminder jika:
            // 1. Belum pernah scan sama sekali, ATAU
            // 2. Scan terakhir sudah lebih dari 3 hari yang lalu
            $shouldRemind = !$lastScan || $lastScan->created_at->diffInDays(now()) >= 3;

            if ($shouldRemind) {
                $message = $this->buildMessage($lastScan);
                $user->notify(new FertilizerCheckReminder($message));
                $sent++;

                $this->line("  ✅ Reminder terkirim ke: {$user->name} ({$user->email})");
            } else {
                $skipped++;
            }
        }

        $this->newLine();
        $this->info("📊 Selesai! Terkirim: {$sent} | Dilewati: {$skipped}");

        return Command::SUCCESS;
    }

    /**
     * Buat pesan reminder yang kontekstual berdasarkan kondisi terakhir.
     */
    protected function buildMessage(?object $lastScan): string
    {
        if (!$lastScan) {
            return 'Anda belum pernah melakukan scan pupuk. Yuk, mulai pantau galon POC Anda sekarang! 🌱';
        }

        $days = $lastScan->created_at->diffInDays(now());

        return match ($lastScan->status) {
            'needs_stirring' => "Sudah {$days} hari sejak scan terakhir. Pupuk Anda sebelumnya perlu diaduk — yuk cek apakah kondisinya sudah membaik! 🔄",
            'contaminated'   => "Sudah {$days} hari sejak scan terakhir. Pupuk Anda sebelumnya terdeteksi terkontaminasi — segera cek kondisinya! ⚠️",
            default          => "Sudah {$days} hari sejak scan terakhir. Saatnya mengecek galon POC Anda untuk memastikan fermentasi tetap berjalan baik! 🌿",
        };
    }
}
