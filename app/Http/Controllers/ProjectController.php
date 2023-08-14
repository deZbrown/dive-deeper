<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\CreateProjectRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::where('user_id', auth()->id())->get();

        return response()->json($projects);
    }

    public function store(CreateProjectRequest $request): JsonResponse
    {
        $project = Project::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_id' => auth()->id(),
        ]);

        return response()->json($project, 201);
    }

    public function show(Project $project): JsonResponse
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($project);
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $project->update($request->validated());

        return response()->json($project);
    }

    public function destroy(Project $project): JsonResponse
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $project->delete();

        return response()->json(null, 204);
    }
}
