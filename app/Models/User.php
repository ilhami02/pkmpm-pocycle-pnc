<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'reminder_enabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'reminder_enabled' => 'boolean',
        ];
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
}
