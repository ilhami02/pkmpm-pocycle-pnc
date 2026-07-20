<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\FertilizerCheckReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Command untuk mengirim reminder berkala ke pengguna.
 * Dijalankan via Task Scheduler (lihat routes/console.php).
 *
 * Usage: php artisan pocycle:send-reminders
 *
 * Logika:
 * - Cari user yang reminder_enabled = true
 * - Cek apakah scan terakhir sudah >= X hari yang lalu
 * - Cek apakah sudah pernah dikirim notifikasi hari ini (anti-duplikasi)
 * - Kirim notifikasi kontekstual berdasarkan status scan terakhir
 */
class SendFertilizerReminders extends Command
{
    protected $signature = 'pocycle:send-reminders
                            {--interval= : Override interval hari (default dari config)}
                            {--dry-run : Tampilkan siapa yang akan dikirimi tanpa benar-benar mengirim}';

    protected $description = 'Kirim reminder berkala untuk mengecek galon POC kepada pengguna yang mengaktifkan reminder';

    public function handle(): int
    {
        $interval = $this->option('interval')
            ?: config('services.fertilizer_api.reminder_interval_days', 3);
        $dryRun = $this->option('dry-run');

        $this->info('🌿 Memulai pengiriman reminder POCYCLE...');
        $this->info("   Interval: setiap {$interval} hari");

        if ($dryRun) {
            $this->warn('   ⚠️  Mode DRY-RUN: tidak ada notifikasi yang benar-benar dikirim.');
        }

        $users = User::where('reminder_enabled', true)->get();

        if ($users->isEmpty()) {
            $this->warn('Tidak ada pengguna dengan reminder aktif.');
            return Command::SUCCESS;
        }

        $this->info("   Ditemukan {$users->count()} pengguna dengan reminder aktif.");
        $this->newLine();

        $sent = 0;
        $skipped = 0;
        $alreadyNotified = 0;

        foreach ($users as $user) {
            $lastScan = $user->scanHistories()->latest()->first();

            // Cek apakah perlu diingatkan berdasarkan interval
            $shouldRemind = !$lastScan || $lastScan->created_at->diffInDays(now()) >= $interval;

            if (!$shouldRemind) {
                $skipped++;
                continue;
            }

            // Anti-duplikasi: cek apakah sudah ada notifikasi reminder hari ini
            $alreadySentToday = $user->notifications()
                ->where('type', FertilizerCheckReminder::class)
                ->whereDate('created_at', today())
                ->exists();

            if ($alreadySentToday) {
                $alreadyNotified++;
                $this->line("  ⏭️  Sudah dikirimi hari ini: {$user->name}");
                continue;
            }

            if ($dryRun) {
                $message = $this->buildMessage($user, $lastScan, $interval);
                $this->line("  🔍 [DRY-RUN] Akan dikirim ke: {$user->name} ({$user->phone})");
                $this->line("     Pesan: {$message}");
                $sent++;
                continue;
            }

            // Kirim notifikasi
            $message = $this->buildMessage($user, $lastScan, $interval);
            $user->notify(new FertilizerCheckReminder($message));
            $sent++;

            $this->line("  ✅ Reminder terkirim ke: {$user->name} ({$user->phone})");
        }

        $this->newLine();
        $this->info("📊 Selesai! Terkirim: {$sent} | Dilewati: {$skipped} | Sudah dikirimi: {$alreadyNotified}");

        Log::info('POCYCLE: Reminder selesai dijalankan', [
            'sent'             => $sent,
            'skipped'          => $skipped,
            'already_notified' => $alreadyNotified,
            'interval_days'    => $interval,
            'dry_run'          => $dryRun,
        ]);

        return Command::SUCCESS;
    }

    /**
     * Buat pesan reminder yang kontekstual berdasarkan kondisi terakhir dan umur fermentasi.
     */
    protected function buildMessage(User $user, ?object $lastScan, int $interval): string
    {
        if (!$lastScan) {
            return 'Anda belum pernah melakukan scan pupuk. Yuk, mulai pantau galon POC Anda sekarang! 🌱';
        }

        $fermentationDay = $user->getFermentationDay();

        if ($fermentationDay >= 21) {
            return "Pupuk POC Anda sudah berusia {$fermentationDay} hari (Minggu ke-3/4)! Yuk cek apakah sudah siap dipanen dan lakukan verifikasi. 🌾";
        }

        $daysSinceLastScan = $lastScan->created_at->diffInDays(now());

        return match ($lastScan->status) {
            'needs_stirring' => "Sudah {$daysSinceLastScan} hari sejak scan terakhir. Pupuk Anda sebelumnya perlu diaduk — yuk cek apakah kondisinya sudah membaik! 🔄",
            'contaminated'   => "Sudah {$daysSinceLastScan} hari sejak scan terakhir. Pupuk Anda sebelumnya terdeteksi terkontaminasi — segera cek kondisinya! ⚠️",
            default          => "Sudah {$daysSinceLastScan} hari sejak scan terakhir. Saatnya mengecek galon POC Anda untuk memastikan fermentasi tetap berjalan baik! 🌿",
        };
    }
}
