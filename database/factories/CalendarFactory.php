<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Calendar;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CalendarFactory extends Factory
{
    protected $model = Calendar::class;

    #[\ReturnTypeWillChange]
    #[\JetBrains\PhpStorm\ArrayShape([
        'id' => "string",
        'user_id' => "string",
        'date' => "string"
    ])]
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'user_id' => User::factory(),
            'date' => $this->faker->date,
        ];
    }
}
