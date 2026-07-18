<?php

namespace App\Livewire\Components;

use Livewire\Component;

class StatOverview extends Component
{
    public $students;
    public $schedules;

    public function mount()
    {
        $user = auth()->user()->load('students.classes.schedules');

        $this->students = $user->students->count();

        $this->schedules = $user->students
            ->pluck('classes')
            ->filter()
            ->flatMap->schedules
            ->unique('id')
            ->count();
    }

    public function render()
    {
        return view('livewire.components.stat-overview');
    }
}