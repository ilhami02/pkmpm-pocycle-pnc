<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fermentation_batch_id',
        'image_path',
        'temperature',
        'detected_color',
        'status',
        'recommendation',
        'ai_raw_response',
        'api_provider',
        'admin_status',
        'admin_note',
        'verified_at',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'temperature'     => 'decimal:1',
            'ai_raw_response' => 'array',
            'verified_at'     => 'datetime',
        ];
    }

    /**
     * Relasi ke user pemilik scan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke batch fermentasi.
     */
    public function batch()
    {
        return $this->belongsTo(FermentationBatch::class, 'fermentation_batch_id');
    }

    /**
     * Relasi ke admin yang memverifikasi scan ini.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Accessor: apakah scan sudah diverifikasi admin.
     */
    public function getIsVerifiedAttribute(): bool
    {
        return !is_null($this->verified_at);
    }

    /**
     * Accessor: status efektif (admin override > AI).
     */
    public function getEffectiveStatusAttribute(): string
    {
        return $this->admin_status ?? $this->status;
    }

    /**
     * Accessor: label status dalam Bahasa Indonesia dengan emoji.
     * Menggunakan effective_status (prioritas admin).
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->effective_status) {
            'normal'         => '✅ Proses Normal',
            'needs_stirring' => '⚠️ Perlu Diaduk',
            'contaminated'   => '🚫 Terkontaminasi',
            default          => '❓ Belum Diketahui',
        };
    }

    /**
     * Accessor: CSS class berdasarkan status untuk styling.
     * Menggunakan effective_status (prioritas admin).
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->effective_status) {
            'normal'         => 'text-green-700 bg-green-50 border-green-200',
            'needs_stirring' => 'text-amber-700 bg-amber-50 border-amber-200',
            'contaminated'   => 'text-red-700 bg-red-50 border-red-200',
            default          => 'text-gray-700 bg-gray-50 border-gray-200',
        };
    }
}
