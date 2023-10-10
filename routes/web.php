<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DayController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ItemController;

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

Route::get('/', function(){
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DayController::class, 'Week'])->name('dashboard');
    Route::post('/calendar/pagination',[DayController::class, 'pagination'])->name('calendar.pagination')->middleware('web');
    Route::post('/calendar/paginationDay',[DayController::class, 'paginationDay'])->name('calendar.paginationDay')->middleware('web');
    Route::post('/calendar/paginationFiveWeek',[DayController::class, 'paginationFiveWeek'])->name('calendar.paginationFiveWeek')->middleware('web');
    Route::post('/calendar/paginationItemFiveWeek',[ItemController::class, 'paginationItemFiveWeek'])->name('calendar.paginationItemFiveWeek')->middleware('web');
    Route::post('/createEvent',[EventController::class,'create'])->name('createEvent');
    Route::post('/editEvent',[EventController::class,'edit'])->name('editEvent');
    Route::post('/editItem',[EventController::class,'editItem'])->name('editItem');
    Route::delete('/deleteEvent',[EventController::class,'delete'])->name('deleteEvent');
    Route::post('/updateEvent',[EventController::class,'update'])->name('updateEvent');
    Route::post('/updateEventWeek',[EventController::class,'updateWeek'])->name('updateEventWeek');
    Route::post('/updateItem',[EventController::class,'updateItem'])->name('updateItem');
    Route::post('/updateItemWeek',[EventController::class,'updateItemWeek'])->name('updateItemWeek');
    Route::get('/item',[ItemController::class,'index'])->name('item');
});

require __DIR__.'/auth.php';
