<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard')->defaults('title', 'Dasbor');

    Route::get('/students-schedules',function() {
        return view('students-schedules.index');
    })->defaults('title','Jadwal Anak')->name('studentsIndex');
});
