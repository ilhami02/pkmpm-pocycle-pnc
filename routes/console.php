<?php

use Illuminate\Support\Facades\Schedule;

// ===================================================
// Task Scheduling — Reminder POC
// ===================================================
// Kirim reminder setiap hari pada jam 08:00 WIB.
// Command-nya sendiri yang menentukan apakah user perlu diingatkan
// berdasarkan interval hari sejak scan terakhir (default: 3 hari, sekarang diset: 2 hari).
// Ini memungkinkan pengiriman harian yang lebih akurat per-user.
Schedule::command('pocycle:send-reminders --interval=2')->dailyAt('08:00');
