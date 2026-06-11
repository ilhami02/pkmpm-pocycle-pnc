<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

/**
 * WhatsAppChannel — Template untuk custom WhatsApp notification channel.
 *
 * BELUM DIIMPLEMENTASIKAN. Ini adalah placeholder/template.
 * Implementasikan method send() dengan WhatsApp API pilihan Anda
 * (Twilio, Fonnte, WA Business API, dll).
 *
 * Cara mengaktifkan:
 * 1. Pilih WhatsApp API provider
 * 2. Implement logic di method send()
 * 3. Uncomment channel di FertilizerCheckReminder::via()
 * 4. Tambah kolom 'whatsapp_number' ke tabel users
 */
class WhatsAppChannel
{
    /**
     * Kirim notifikasi via WhatsApp.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        // Ambil data dari notification
        $data = $notification->toWhatsApp($notifiable);

        $phone = $data['phone'] ?? null;
        $message = $data['message'] ?? '';

        if (empty($phone)) {
            return;
        }

        // ==============================================
        // TODO: Implementasikan dengan WhatsApp API
        // ==============================================
        //
        // Contoh dengan Fonnte:
        // Http::withToken(config('services.fonnte.token'))
        //     ->post('https://api.fonnte.com/send', [
        //         'target'  => $phone,
        //         'message' => $message,
        //     ]);
        //
        // Contoh dengan Twilio:
        // $twilio = new \Twilio\Rest\Client($sid, $token);
        // $twilio->messages->create("whatsapp:{$phone}", [
        //     'from' => 'whatsapp:' . config('services.twilio.whatsapp_from'),
        //     'body' => $message,
        // ]);
        // ==============================================
    }
}
