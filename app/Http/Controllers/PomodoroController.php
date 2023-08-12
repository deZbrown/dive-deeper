<?php

namespace App\Http\Controllers;

use App\Models\Pomodoro;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StorePomodoroRequest;

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
}
