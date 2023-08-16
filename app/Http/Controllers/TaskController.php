<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = auth()->user()->tasks;

        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = new Task($request->validated());

        $task->user_id = auth()->id();
        $task->save();

        return response()->json($task, 201);
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task->update($request->all());

        return response()->json($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json(null, 204);
    }

    public function addTaskToProject(Task $task, Project $project): JsonResponse
    {
        $task->project_id = $project->id;
        $task->save();

        return response()->json($task);
    }

    public function removeTaskFromProject(Task $task): JsonResponse
    {
        $task->project_id = null;
        $task->save();

        return response()->json($task);
    }
}
