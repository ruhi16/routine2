<?php
namespace App\Http\Livewire;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


use App\Http\Livewire\AdminScheduleDetailsComponent;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/schedule', AdminScheduleContainerComponent::class)
    ->middleware(['auth'])->name('schedule');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');




require __DIR__.'/auth.php';
