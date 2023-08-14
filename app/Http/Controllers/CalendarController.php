<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreateCalendarRequest;
use App\Http\Requests\UpdateCalendarRequest;

class CalendarController extends Controller
{
    public function index(): JsonResponse
    {
        $calendars = Calendar::all();

        return response()->json($calendars);
    }

    public function store(CreateCalendarRequest $request): JsonResponse
    {
        $calendar = Calendar::create([
            'date' => $request->input('date'),
        ]);

        return response()->json($calendar, 201);
    }

    public function show(Calendar $calendar): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($calendar);
    }

    public function update(UpdateCalendarRequest $request, Calendar $calendar): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $calendar->update($request->validated());

        return response()->json($calendar);
    }

    public function destroy(Calendar $calendar): JsonResponse
    {
        if ($calendar->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $calendar->delete();

        return response()->json(null, 204);
    }

}
