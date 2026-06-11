<?php

use Illuminate\Support\Facades\Schedule;

// ===================================================
// Task Scheduling — Reminder POC
// ===================================================
// Kirim reminder setiap 3 hari pada jam 08:00 WIB
Schedule::command('pocycle:send-reminders')->cron('0 8 */3 * *');
