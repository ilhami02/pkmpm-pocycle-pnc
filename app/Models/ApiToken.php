<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'token',
        'priority',
        'is_active',
        'last_used_at',
        'rate_limited_until',
        'usage_count',
    ];

    protected function casts(): array
    {
        return [
            'is_active'          => 'boolean',
            'last_used_at'       => 'datetime',
            'rate_limited_until' => 'datetime',
        ];
    }

    /**
     * Enkripsi/dekripsi token API secara otomatis.
     * Token disimpan terenkripsi di database untuk keamanan.
     */
    protected function token(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => decrypt($value),
            set: fn (string $value) => encrypt($value),
        );
    }

    /**
     * Scope: hanya token yang aktif dan tidak sedang rate-limited.
     * Urutan: Round Robin — token yang paling lama tidak digunakan diprioritaskan.
     * Token baru (last_used_at = NULL) akan digunakan lebih dulu.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('rate_limited_until')
                  ->orWhere('rate_limited_until', '<', now());
            })
            ->orderByRaw('CASE WHEN last_used_at IS NULL THEN 0 ELSE 1 END ASC, last_used_at ASC');
    }
}
