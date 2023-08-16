<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCalendarRequest;
use App\Http\Requests\UpdateCalendarRequest;
use App\Models\Calendar;
use Illuminate\Http\JsonResponse;

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
        return response()->json($calendar);
    }

    public function update(UpdateCalendarRequest $request, Calendar $calendar): JsonResponse
    {
        $calendar->update($request->validated());

        return response()->json($calendar);
    }

    public function destroy(Calendar $calendar): JsonResponse
    {
        $calendar->delete();

        return response()->json(null, 204);
    }
}
