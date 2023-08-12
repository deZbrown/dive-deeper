<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Pomodoro;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pomodoro>
 */
class PomodoroFactory extends Factory
{
    protected $model = Pomodoro::class;

    #[\ReturnTypeWillChange]
    #[\JetBrains\PhpStorm\ArrayShape([
        'id' => "string",
        'task_id' => Task::class,
        'duration' => "int",
        'start_time' => \DateTimeInterface::class,
        'end_time' => \DateTimeInterface::class
    ])]
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'task_id' => Task::factory(),
            'duration' => $this->faker->numberBetween(25, 60),
            'start_time' => $this->faker->dateTime,
            'end_time' => $this->faker->dateTime,
        ];
    }

    public function forTask($task): Factory
    {
        return $this->state(function (array $attributes) use ($task) {
            return [
                'task_id' => $task->id,
            ];
        });
    }
}
