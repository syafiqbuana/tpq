<?php

namespace App\Livewire\Components;
use App\Models\User;
use Livewire\Component;

class ScheduleReminder extends Component
{
    public $todaySchedule;

    // 1. Terima instance model Student (misal dikirim dari view parent/controller)
    public function mount() 
    {
        // 2. Akses custom attribute dan simpan ke properti public $todaySchedule
        $this->todaySchedule = auth()->user()->today_schedule_reminder;
    }

    public function render()
    {
        return view('livewire.components.schedule-reminder');
    }
}