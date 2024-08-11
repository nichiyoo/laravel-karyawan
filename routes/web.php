<?php

use App\Livewire\Employee;
use App\Livewire\EmployeeFamily;
use Illuminate\Support\Facades\Route;

Route::get('/', Employee\CreateEmployee::class);
Route::get('/family', EmployeeFamily\CreateEmployeeFamily::class)
    ->middleware([
        Filament\Http\Middleware\Authenticate::class,
    ]);
