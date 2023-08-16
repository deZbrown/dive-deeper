<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    #[\ReturnTypeWillChange]
    #[\JetBrains\PhpStorm\ArrayShape([
        'id' => 'string',
        'name' => 'string',
        'description' => 'string|null',
        'user_id' => Factory::class,
    ])]
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'user_id' => User::factory(),
        ];
    }
}
