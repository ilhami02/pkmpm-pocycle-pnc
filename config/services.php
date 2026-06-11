<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fertilizer Analysis API Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk API analisis pupuk. Token disimpan di database
    | melalui tabel api_tokens untuk mendukung multi-token fallback.
    |
    */
    'fertilizer_api' => [
        'default_provider' => env('FERTILIZER_API_PROVIDER', 'gemini'),
        'timeout' => env('FERTILIZER_API_TIMEOUT', 30),
        'rate_limit_cooldown_minutes' => env('FERTILIZER_API_COOLDOWN', 60),
    ],
];
