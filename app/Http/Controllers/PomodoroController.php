<?php

namespace App\Http\Controllers;

use App\Models\Pomodoro;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorePomodoroRequest;
use App\Http\Requests\FetchPomodoroRequest;
use App\Http\Requests\UpdatePomodoroRequest;

class PomodoroController extends Controller
{
    public function index(): JsonResponse
    {
        $pomodoros = Pomodoro::all();

        return response()->json($pomodoros);
    }

    public function store(StorePomodoroRequest $request): JsonResponse
    {
        $pomodoro = Pomodoro::create($request->validated());

        return response()->json($pomodoro, 201);
    }

    public function show(Pomodoro $pomodoro): JsonResponse
    {
        return response()->json($pomodoro);
    }

    public function update(UpdatePomodoroRequest $request, Pomodoro $pomodoro): JsonResponse
    {
        $pomodoro->update($request->validated());

        return response()->json($pomodoro);
    }

    public function destroy(Pomodoro $pomodoro): JsonResponse
    {
        $pomodoro->delete();

        return response()->json(null, 204);
    }

    public function startPomodoroTimer(Pomodoro $pomodoro): JsonResponse
    {
        $pomodoro->start();

        return response()->json($pomodoro->refresh());
    }

    public function stopPomodoroTimer(Pomodoro $pomodoro): JsonResponse
    {
        $pomodoro->stop();

        return response()->json($pomodoro->refresh());
    }

}
