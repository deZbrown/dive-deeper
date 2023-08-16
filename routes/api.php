<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\PomodoroController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('/tasks', [TaskController::class, 'index'])->can('viewAny,App\Models\Task');
    Route::post('/tasks', [TaskController::class, 'store'])->can('create,App\Models\Task');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->can('view,task');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->can('update,task');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->can('delete,task');
    Route::post('/tasks/{task}/projects/{project}', [TaskController::class, 'addTaskToProject']);
    Route::delete('/tasks/{task}/projects', [TaskController::class, 'removeTaskFromProject']);

    /**
     * Pomodoro routes
     */
    Route::get('/pomodoros', [PomodoroController::class, 'index']);
    Route::post('/pomodoros', [PomodoroController::class, 'store']);
    Route::get('/pomodoros/{pomodoro}', [PomodoroController::class, 'show'])->can('view,pomodoro');
    Route::put('/pomodoros/{pomodoro}', [PomodoroController::class, 'update'])->can('update,pomodoro');
    Route::delete('/pomodoros/{pomodoro}', [PomodoroController::class, 'destroy'])->can('delete,pomodoro');
    Route::post('/pomodoros/{pomodoro}/start', [PomodoroController::class, 'startPomodoroTimer']);
    Route::post('/pomodoros/{pomodoro}/stop', [PomodoroController::class, 'stopPomodoroTimer']);

    /**
     * Project routes
     */
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->can('view', 'project');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->can('update', 'project');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->can('delete', 'project');

    /**
     * Calendar routes
     */
    Route::get('/calendars', [CalendarController::class, 'index']);
    Route::post('/calendars', [CalendarController::class, 'store']);
    Route::get('/calendars/{calendar}', [CalendarController::class, 'show'])->can('view', 'calendar');
    Route::put('/calendars/{calendar}', [CalendarController::class, 'update'])->can('update', 'calendar');
    Route::delete('/calendars/{calendar}', [CalendarController::class, 'destroy'])->can('delete', 'calendar');
});
