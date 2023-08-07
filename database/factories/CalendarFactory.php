<?php

namespace Database\Factories;

use App\Models\Calendar;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Calendar>
 */
class CalendarFactory extends Factory
{
    protected $model = Calendar::class;

    #[\ReturnTypeWillChange]
    #[\JetBrains\PhpStorm\ArrayShape([
        'id' => "string",
        'date' => "string"
    ])]
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'date' => $this->faker->date,
        ];
    }
}
