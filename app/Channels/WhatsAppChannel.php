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
        $phone = $notifiable->phone;
        
        if (!$phone) {
            return;
        }

        // Format phone number (change leading 0 to 62 if necessary)
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        if (!method_exists($notification, 'toWhatsApp')) {
            \Illuminate\Support\Facades\Log::warning('Notification class ' . get_class($notification) . ' is missing toWhatsApp method.');
            return;
        }

        $message = $notification->toWhatsApp($notifiable);
        $token = config('services.fonnte.token');

        if (!$token) {
            \Illuminate\Support\Facades\Log::warning('Token Fonnte belum di-set di .env');
            return;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()->withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $phone,
                'message' => $message,
                'delay' => '1',
            ]);

            if (!$response->successful()) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim WhatsApp via Fonnte', ['response' => $response->body()]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error WhatsAppChannel: ' . $e->getMessage());
        }
    }
}
