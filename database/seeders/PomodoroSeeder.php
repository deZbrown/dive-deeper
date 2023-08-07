<?php

namespace Database\Seeders;

use App\Models\Pomodoro;
use Illuminate\Database\Seeder;

class PomodoroSeeder extends Seeder
{
    public function run(): void
    {
        Pomodoro::factory(50)->create();
    }
}
