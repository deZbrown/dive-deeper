<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Pomodoro;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PomodoroControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_pomodoros(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->withoutPomodoro()->create(['user_id' => $user->id]);
        Pomodoro::factory()->forTask($task)->create();

        $response = $this->actingAs($user)->get('/api/v1/pomodoros');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_can_create_pomodoro(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->withoutPomodoro()->create(['user_id' => $user->id]);

        $pomodoroData = [
            'task_id' => $task->id,
            'duration' => 300,
        ];

        $response = $this->actingAs($user)->post('/api/v1/pomodoros', $pomodoroData);

        $response->assertStatus(201);
        $response->assertJsonFragment($pomodoroData);
    }

}
