<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PomodoroController;
use App\Http\Controllers\CalendarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    /**
     * User routes
     */

    Route::get('/user', static function (Request $request) {
        return $request->user();
    });

    /**
     * Tasks routes
     */

    Route::get('/tasks', [TaskController::class, 'index']);

    Route::post('/tasks', [TaskController::class, 'store']);

    Route::get('/tasks/{task}', [TaskController::class, 'show']);

    Route::put('/tasks/{task}', [TaskController::class, 'update']);

    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);

    /**
     * Pomodoro routes
     */
    Route::get('/pomodoros', [PomodoroController::class, 'index']);

    Route::post('/pomodoros', [PomodoroController::class, 'store']);

    Route::get('/pomodoros/{pomodoro}', [PomodoroController::class, 'show']);

    Route::put('/pomodoros/{pomodoro}', [PomodoroController::class, 'update']);

    Route::delete('/pomodoros/{pomodoro}', [PomodoroController::class, 'destroy']);

    Route::post('/pomodoros/{pomodoro}/start', [PomodoroController::class, 'startPomodoroTimer']);

    Route::post('/pomodoros/{pomodoro}/stop', [PomodoroController::class, 'stopPomodoroTimer']);

    /**
     * Project routes
     */
    Route::get('/projects', [ProjectController::class, 'index']);

    Route::post('/projects', [ProjectController::class, 'store']);

    Route::get('/projects/{project}', [ProjectController::class, 'show']);

    Route::put('/projects/{project}', [ProjectController::class, 'update']);

    Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);

    /**
     * Calendar routes
     */
    Route::get('/calendars', [CalendarController::class, 'index']);

    Route::post('/calendars', [CalendarController::class, 'store']);

    Route::get('/calendars/{calendar}', [CalendarController::class, 'show']);

    Route::put('/calendars/{calendar}', [CalendarController::class, 'update']);

    Route::delete('/calendars/{calendar}', [CalendarController::class, 'destroy']);
});
