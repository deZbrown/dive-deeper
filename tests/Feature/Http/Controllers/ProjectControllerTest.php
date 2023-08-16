<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_projects(): void
    {
        $user = User::factory()->create();
        Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/api/v1/projects');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_can_create_project(): void
    {
        $user = User::factory()->create();

        $projectData = [
            'name' => 'Sample Project',
            'description' => 'Description of the project',
        ];

        $response = $this->actingAs($user)->post('/api/v1/projects', $projectData);

        $response->assertStatus(201);
        $response->assertJsonFragment($projectData);
    }

    public function test_can_show_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/api/v1/projects/'.$project->id);

        $response->assertStatus(200);
        $response->assertJsonFragment($project->toArray());
    }

    public function test_can_update_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'name' => 'Updated Project Name',
            'description' => 'Updated Description',
        ];

        $response = $this->actingAs($user)->put('/api/v1/projects/'.$project->id, $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updatedData);
    }

    public function test_can_delete_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete('/api/v1/projects/'.$project->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_non_owner_cannot_access_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->for(User::factory())->create();

        Sanctum::actingAs($user);

        $response = $this->getJson("/api/v1/projects/{$project->id}");

        $response->assertStatus(403);
    }
}
