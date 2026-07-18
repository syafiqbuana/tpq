<?php

namespace App\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;

class AttendanceTodayWidget extends Component
{
    // Gunakan satu variabel array untuk menampung semua data anak
    public array $studentsData = [];

    public function mount()
    {
        // 1. Ambil user beserta semua siswanya (lengkap dengan kelas dan jadwal)
        $user = auth()->user()->load('students.classes.schedules');
        $students = $user->students;

        // 2. Looping setiap siswa milik user tersebut
        foreach ($students as $student) {
            $class = $student->classes; // Asumsi belongsTo sesuai kodemu

            // Data default jika tidak ada kelas/jadwal
            $studentInfo = [
                'name'             => $student->name,
                'class_name'       => $class ? $class->name : 'Belum ada kelas',
                'schedule_name'    => 'Tidak ada jadwal',
                'attendance_status'=> 'Belum ada sesi',
            ];

            // 3. Jika siswa punya kelas dan kelasnya punya jadwal
            if ($class && $class->schedules->isNotEmpty()) {
                $dayName = strtolower(Carbon::today()->format('l'));

                $todaySchedule = $class->schedules->first(function ($schedule) use ($dayName) {
                    $daysArray = array_map('trim', explode(',', $schedule->day ?? ''));
                    return in_array($dayName, $daysArray);
                });

                if ($todaySchedule) {
                    $studentInfo['schedule_name'] = $todaySchedule->name;
                    $studentInfo['attendance_status'] = $this->resolveAttendanceStatus($student, $todaySchedule);
                }
            }

            // 4. Masukkan data siswa ini ke dalam array utama
            $this->studentsData[] = $studentInfo;
        }
    }

    private function resolveAttendanceStatus($student, $schedule): string
    {
        $now       = Carbon::now();
        $timeOpen  = Carbon::today()->setTimeFromTimeString($schedule->time_open);
        
        $attendance = $student->attendances()
            ->whereDate('date', Carbon::today())
            ->where('schedule_id', $schedule->id)
            ->first();

        if (!$attendance) {
            return 'Belum ada sesi';
        }

        if ($now->lt($timeOpen)) {
            return 'Belum Dibuka';
        }

        return match ($attendance->status) {
            'pending'    => 'Menunggu Absensi',
            'present'    => 'Hadir',
            'sick'       => 'Sakit',
            'permission' => 'Izin',
            'absent'     => 'Alfa',
            'holiday'    => 'Hari Libur',
            default      => $attendance->status,
        };
    }

    public function render()
    {
        return view('livewire.components.attendance-today-widget');
    }
}