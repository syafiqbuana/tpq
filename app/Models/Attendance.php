<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'date', 'time_in'];

    protected $casts = [
        'date' => 'date',
        'time_in' => 'datetime:H:i:s',
    ];

    public function attendanceStatus()
    {
        $schedule = $this->student->schedules;

        if($this->time_in->gt($schedule->time_close)){
            return 'absent';
        };

        if($this->time_in->gt($schedule->time_open->copy()->addHour()))
            {
                return 'late';
            }

        return 'on time';
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
