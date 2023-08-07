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

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
