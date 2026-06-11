<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * FertilizerCheckReminder
 *
 * Notifikasi reminder untuk mengecek galon POC.
 * Struktur modular — saat ini menggunakan channel 'database',
 * siap ditambahkan WhatsApp channel di masa depan tanpa merombak logic.
 *
 * Cara menambahkan WhatsApp channel:
 * 1. Buat App\Channels\WhatsAppChannel
 * 2. Uncomment WhatsApp channel di method via()
 * 3. Implement method toWhatsApp()
 */
class FertilizerCheckReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $message = 'Sudah waktunya mengecek galon POC Anda! Lakukan scan untuk memastikan proses fermentasi berjalan dengan baik. 🌿',
        protected string $type = 'routine_check'
    ) {}

    /**
     * Channel pengiriman — MODULAR via() method.
     *
     * Tinggal tambahkan channel baru di array ini:
     * - 'database' → notifikasi di dalam web app
     * - WhatsAppChannel::class → kirim ke WhatsApp (future)
     * - 'mail' → kirim email (future)
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        // =========================================
        // FUTURE: WhatsApp Channel
        // =========================================
        // Uncomment baris di bawah setelah membuat
        // App\Channels\WhatsAppChannel
        //
        // if ($notifiable->whatsapp_number) {
        //     $channels[] = \App\Channels\WhatsAppChannel::class;
        // }
        // =========================================

        return $channels;
    }

    /**
     * Data untuk notifikasi database (muncul di web app).
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title'      => '🌿 Waktunya Cek Pupuk!',
            'message'    => $this->message,
            'type'       => $this->type,
            'action_url' => '/scan',
            'action_text' => 'Scan Sekarang',
        ];
    }

    /**
     * FUTURE: Data untuk WhatsApp channel.
     * Uncomment dan implementasikan saat sudah siap.
     */
    // public function toWhatsApp(object $notifiable): array
    // {
    //     return [
    //         'phone'   => $notifiable->whatsapp_number,
    //         'message' => "🌿 *POCYCLE Reminder*\n\n{$this->message}\n\nKlik link berikut untuk scan: " . url('/scan'),
    //     ];
    // }
}
