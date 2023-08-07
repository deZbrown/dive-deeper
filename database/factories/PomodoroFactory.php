<?php

namespace Database\Factories;

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
        'duration' => "int",
        'start_time' => \DateTimeInterface::class,
        'end_time' => \DateTimeInterface::class
    ])]
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'duration' => $this->faker->numberBetween(25, 60),
            'start_time' => $this->faker->dateTime,
            'end_time' => $this->faker->dateTime,
        ];
    }
}
