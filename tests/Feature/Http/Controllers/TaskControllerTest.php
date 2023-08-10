<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_list_all_tasks(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/api/v1/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function test_can_create_new_task(): void
    {
        $user = User::factory()->create();
        $taskData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $response = $this->actingAs($user)->post('/api/v1/tasks', $taskData);

        $response->assertStatus(201);
        $response->assertJson($taskData);
    }

    public function test_can_get_specific_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/tasks/' . $task->id);

        $response->assertStatus(200);
        $response->assertJson($task->toArray());
    }

    public function test_can_update_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $updatedData = [
            'title' => 'Updated Title',
            // Add other fields to update
        ];

        $response = $this->actingAs($user)->put('/tasks/' . $task->id, $updatedData);

        $response->assertStatus(200);
        $response->assertJson($updatedData);
    }

    public function test_can_delete_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete('/tasks/' . $task->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_can_start_pomodoro_timer(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post('/tasks/' . $task->id . '/start');

        $response->assertStatus(200);
        // Add assertions to verify the Pomodoro timer has started
    }

    public function test_can_stop_pomodoro_timer(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post('/tasks/' . $task->id . '/stop');

        $response->assertStatus(200);
        // Add assertions to verify the Pomodoro timer has stopped
    }
}
