<?php

namespace Database\Factories;

use App\Models\Calendar;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    #[\ReturnTypeWillChange]
    #[\JetBrains\PhpStorm\ArrayShape([
        'id' => 'string',
        'user_id' => User::class,
        'title' => 'string',
        'description' => 'string',
        'is_completed' => 'bool',
        'calendar_id' => Calendar::class,
        'project_id' => Project::class,
    ])]
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'is_completed' => $this->faker->boolean,
            'calendar_id' => Calendar::factory(),
            'project_id' => Project::factory(),
        ];
    }
}
