<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FermentationBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'started_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke user pemilik batch.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke riwayat scan batch ini.
     */
    public function scanHistories()
    {
        return $this->hasMany(ScanHistory::class);
    }

    /**
     * Hitung umur fermentasi (hari ke-berapa).
     */
    public function getFermentationDay(): int
    {
        if (!$this->started_at) {
            return 0;
        }

        return $this->started_at->diffInDays(now()) + 1;
    }

    /**
     * Scope: hanya batch yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Accessor: label status dalam Bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active'    => '🟢 Aktif',
            'harvested' => '🌾 Dipanen',
            'failed'    => '🚫 Gagal',
            default     => '❓ Tidak Diketahui',
        };
    }

    /**
     * Accessor: CSS class berdasarkan status.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active'    => 'text-green-700 bg-green-50 border-green-200',
            'harvested' => 'text-amber-700 bg-amber-50 border-amber-200',
            'failed'    => 'text-red-700 bg-red-50 border-red-200',
            default     => 'text-gray-700 bg-gray-50 border-gray-200',
        };
    }
}
