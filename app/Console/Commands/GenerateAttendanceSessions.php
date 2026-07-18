<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Schedules;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateAttendanceSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:generate-sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sesi attendance 5 menit setelah time_open jadwal';

    /**
     * Execute the console command.
     */
public function handle()
{
    $now = Carbon::now();
    $dayName = strtolower($now->format('l')); 

    // Hapus pencarian berdasarkan waktu, cukup cari berdasarkan HARI SAJA
    $schedules = Schedules::whereRaw("FIND_IN_SET(?, day)", [$dayName])
        ->with('classes.students')
        ->get();

    if ($schedules->isEmpty()) {
        $this->info("Tidak ada jadwal yang cocok pada hari {$dayName}.");
        return self::SUCCESS;
    }

    $created = 0;

    foreach ($schedules as $schedule) {
        $studentIds = $schedule->classes
            ->flatMap(fn ($class) => $class->students)
            ->pluck('id')
            ->unique();

        if ($studentIds->isEmpty()) {
            continue;
        }

        // Cek siapa saja yang sudah absen hari ini
        $existingAttendances = Attendance::where('schedule_id', $schedule->id)
            ->where('date', $now->toDateString())
            ->whereIn('student_id', $studentIds)
            ->pluck('student_id')
            ->toArray();

        // Cari siswa yang BELUM ada di tabel attendance
        $missingStudentIds = array_diff($studentIds->toArray(), $existingAttendances);

        if (!empty($missingStudentIds)) {
            $insertData = [];
            foreach ($missingStudentIds as $studentId) {
                $insertData[] = [
                    'schedule_id' => $schedule->id,
                    'student_id'  => $studentId,
                    'date'        => $now->toDateString(),
                    'status'      => 'pending', // Set status awal sebagai pending
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }

            Attendance::insert($insertData);
            $created += count($insertData);
        }

        $this->info("Schedule #{$schedule->id} ({$schedule->name}): " . count($missingStudentIds) . " siswa diproses.");
    }

    $this->info("Selesai. Total attendance baru dibuat: {$created}");
    return self::SUCCESS;
}
}
