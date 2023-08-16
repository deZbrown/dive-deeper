<?php

namespace Database\Factories;

use App\Models\Pomodoro;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Pomodoro>
 */
class PomodoroFactory extends Factory
{
    protected $model = Pomodoro::class;

    #[\ReturnTypeWillChange]
    #[\JetBrains\PhpStorm\ArrayShape([
        'id' => 'string',
        'task_id' => Task::class,
        'duration' => 'int',
        'start_time' => \DateTimeInterface::class,
        'end_time' => \DateTimeInterface::class,
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
}
