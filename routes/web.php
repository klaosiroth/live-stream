<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::group(['prefix' => 'program'], function () {
        Route::get('/', [ProgramController::class, 'index']);
        Route::get('/add', [ProgramController::class, 'addProgram']);
        Route::post('/add', [ProgramController::class, 'postProgram']);
        Route::get('/edit/{id}', [ProgramController::class, 'editProgram']);
        Route::put('/edit/{id}', [ProgramController::class, 'updateProgram']);
        Route::delete('/delete/{id}', [ProgramController::class, 'deleteProgram']);
    });
    Route::group(['prefix' => 'schedule'], function () {
        Route::get('/', [ScheduleController::class, 'index']);
        Route::get('/program/{programId}', [ScheduleController::class, 'index']);
        Route::get('/add', [ScheduleController::class, 'addSchedule']);
        Route::post('/add', [ScheduleController::class, 'postSchedule']);
        Route::get('/edit/{id}', [ScheduleController::class, 'editSchedule']);
        Route::put('/edit/{id}', [ScheduleController::class, 'updateSchedule']);
        Route::delete('/delete/{id}', [ScheduleController::class, 'deleteSchedule']);
    });
});
