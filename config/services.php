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
        'max_image_dimension' => env('FERTILIZER_API_MAX_IMAGE_DIM', 1024),
        'image_quality' => env('FERTILIZER_API_IMAGE_QUALITY', 80),
        'reminder_interval_days' => env('FERTILIZER_REMINDER_INTERVAL', 3),
        'model' => env('FERTILIZER_API_MODEL', 'gemini-1.5-flash'),
    ],
];
