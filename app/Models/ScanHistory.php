<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'temperature',
        'detected_color',
        'status',
        'recommendation',
        'ai_raw_response',
        'api_provider',
    ];

    protected function casts(): array
    {
        return [
            'temperature'     => 'decimal:1',
            'ai_raw_response' => 'array',
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
     * Accessor: label status dalam Bahasa Indonesia dengan emoji.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'normal'         => '✅ Proses Normal',
            'needs_stirring' => '⚠️ Perlu Diaduk',
            'contaminated'   => '🚫 Terkontaminasi',
            default          => '❓ Belum Diketahui',
        };
    }

    /**
     * Accessor: CSS class berdasarkan status untuk styling.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'normal'         => 'text-green-700 bg-green-50 border-green-200',
            'needs_stirring' => 'text-amber-700 bg-amber-50 border-amber-200',
            'contaminated'   => 'text-red-700 bg-red-50 border-red-200',
            default          => 'text-gray-700 bg-gray-50 border-gray-200',
        };
    }
}
