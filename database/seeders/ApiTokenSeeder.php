<?php

namespace Database\Seeders;

use App\Models\ApiToken;
use Illuminate\Database\Seeder;

class ApiTokenSeeder extends Seeder
{
    /**
     * Seed API token contoh.
     * Ganti value token dengan API key asli Anda.
     */
    public function run(): void
    {
        $tokens = [
            [
                'provider' => 'gemini',
                'token'    => 'YOUR_GEMINI_API_KEY_1',  // Ganti dengan key asli
                'priority' => 0,                        // Prioritas tertinggi
                'is_active' => true,
            ],
            [
                'provider' => 'gemini',
                'token'    => 'YOUR_GEMINI_API_KEY_2',  // Key cadangan 1
                'priority' => 1,
                'is_active' => true,
            ],
            [
                'provider' => 'gemini',
                'token'    => 'YOUR_GEMINI_API_KEY_3',  // Key cadangan 2
                'priority' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($tokens as $data) {
            ApiToken::create($data);
        }
    }
}
