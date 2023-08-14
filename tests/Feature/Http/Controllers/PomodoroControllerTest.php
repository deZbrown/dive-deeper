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

    public function test_can_show_pomodoro(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->withoutPomodoro()->create(['user_id' => $user->id]);
        $pomodoro = Pomodoro::factory()->forTask($task)->create();

        $response = $this->actingAs($user)->get('/api/v1/pomodoros/' . $pomodoro->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'end_time' => $pomodoro->end_time->format('Y-m-d H:i:s'),
            'id' => $pomodoro->id,
        ]);
    }

    public function test_can_update_pomodoro(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->withoutPomodoro()->create(['user_id' => $user->id]);
        $pomodoro = Pomodoro::factory()->forTask($task)->create();

        $updatedData = [
            'duration' => 450,
            'start_time' => '2023-08-15 12:00:00',
            'end_time' => '2023-08-15 12:30:00',
        ];

        $response = $this->actingAs($user)->put('/api/v1/pomodoros/' . $pomodoro->id, $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updatedData);
    }

    public function test_can_delete_pomodoro(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->withoutPomodoro()->create(['user_id' => $user->id]);
        $pomodoro = Pomodoro::factory()->forTask($task)->create();

        $response = $this->actingAs($user)->delete('/api/v1/pomodoros/' . $pomodoro->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('pomodoros', ['id' => $pomodoro->id]);
    }


}
