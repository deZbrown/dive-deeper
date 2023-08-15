<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Pomodoro;
use Database\Factories\ProjectFactory;
use Database\Factories\PomodoroFactory;
use Database\Factories\CalendarFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_list_all_tasks(): void
    {
        $user = User::factory()
            ->has(Task::factory()
                ->count(5)
                ->has(Pomodoro::factory()
                    ->count(1)
                    ->forTask(function() {
                        return Task::factory();
                    })
                )
            )
            ->create();


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

        $response = $this->actingAs($user)->get('/api/v1/tasks/' . $task->id);

        $response->assertStatus(200);
        $response->assertJson($task->toArray());
    }

    public function test_can_update_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $pomodoro = PomodoroFactory::new()->create();
        $calendar = CalendarFactory::new()->create();
        $project = ProjectFactory::new()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated description text',
            'is_completed' => true,
            'pomodoro_id' => $pomodoro->id,
            'calendar_id' => $calendar->id,
            'project_id' => $project->id,
        ];

        $response = $this->actingAs($user)->put('/api/v1/tasks/' . $task->id, $updatedData);

        $response->assertStatus(200);
        $response->assertJson($updatedData);

        $task->refresh();
        $this->assertEquals($updatedData['title'], $task->title);
        $this->assertEquals($updatedData['description'], $task->description);
        $this->assertEquals($updatedData['is_completed'], $task->is_completed);
        $this->assertEquals($updatedData['pomodoro_id'], $task->pomodoro_id);
        $this->assertEquals($updatedData['calendar_id'], $task->calendar_id);
        $this->assertEquals($updatedData['project_id'], $task->project_id);
    }


    public function test_can_delete_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete('/api/v1/tasks/' . $task->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
