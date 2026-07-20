<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPushSubscriptions;

    protected $fillable = [
        'name',
        'username',
        'phone',
        'password',
        'reminder_enabled',
        'is_admin',
        'current_batch_started_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'reminder_enabled' => 'boolean',
            'is_admin' => 'boolean',
            'current_batch_started_at' => 'datetime',
        ];
    }

    /**
     * Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Relasi ke riwayat scan pupuk.
     */
    public function scanHistories()
    {
        return $this->hasMany(ScanHistory::class);
    }

    /**
     * Ambil scan terakhir pengguna.
     */
    public function latestScan()
    {
        return $this->hasOne(ScanHistory::class)->latestOfMany();
    }

    /**
     * Hitung umur fermentasi (hari ke-berapa).
     * Dihitung berdasarkan current_batch_started_at. Jika null, berarti belum mulai batch (Hari ke-1).
     */
    public function getFermentationDay(): int
    {
        if (!$this->current_batch_started_at) {
            // Coba lihat apakah ada scan pertama, sebagai fallback awal
            $firstScan = $this->scanHistories()->oldest()->first();
            if ($firstScan) {
                // Update ke database agar ke depannya tercatat
                $this->update(['current_batch_started_at' => $firstScan->created_at]);
                return $firstScan->created_at->diffInDays(now()) + 1;
            }
            return 1;
        }

        return $this->current_batch_started_at->diffInDays(now()) + 1;
    }
}
