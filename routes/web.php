<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/welcome', [DayController::class, 'Week'])->name('welcome');
Route::post('/calendar/pagination',[DayController::class, 'pagination'])->name('calendar.pagination')->middleware('web');
Route::post('/calendar/paginationDay',[DayController::class, 'paginationDay'])->name('calendar.paginationDay')->middleware('web');
Route::post('/calendar/paginationFiveWeek',[DayController::class, 'paginationFiveWeek'])->name('calendar.paginationFiveWeek')->middleware('web');
