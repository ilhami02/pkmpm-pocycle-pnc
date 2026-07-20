<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

/**
 * FertilizerCheckReminder
 *
 * Notifikasi reminder untuk mengecek galon POC.
 * Struktur modular — saat ini menggunakan channel 'database' dan 'webpush'.
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
     */
    public function via(object $notifiable): array
    {
        $channels = ['database', WebPushChannel::class];

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
     * Data untuk notifikasi Web Push (Browser).
     */
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('🌿 Waktunya Cek Pupuk!')
            ->icon(asset('assets/Logo PKM.png'))
            ->body($this->message)
            ->action('Scan Sekarang', 'scan_action')
            ->data(['url' => url('/scan')]);
    }
}
