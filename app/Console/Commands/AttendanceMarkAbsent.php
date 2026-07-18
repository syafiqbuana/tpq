<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Schedules;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AttendanceMarkAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mark-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'set attendance status to absent when status is pending and time_close is passed';


    /**
     * Execute the console command.
     */
public function handle()
{
    $now = Carbon::now(); // pastikan timezone app = Asia/Jakarta di config/app.php
    $dayName = strtolower($now->format('l'));
    $currentTime = $now->format('H:i:s');

    // Cari semua jadwal hari ini yang sudah melewati time_close (tanpa batasan window)
    $scheduleIds = Schedules::where('time_close', '<=', $currentTime)
        ->whereRaw("FIND_IN_SET(?, day)", [$dayName])
        ->pluck('id');

    if ($scheduleIds->isEmpty()) {
        $this->info("Belum ada jadwal yang melewati time_close saat ini.");
        return self::SUCCESS;
    }

    $updatedCount = Attendance::whereIn('schedule_id', $scheduleIds)
        ->where('date', $now->toDateString())
        ->where('status', 'pending')
        ->update(['status' => 'absent']);

    $this->info("Berhasil mengubah {$updatedCount} status pending menjadi alfa.");
    return self::SUCCESS;
}
}
