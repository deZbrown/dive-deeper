<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            ProjectSeeder::class,
            PomodoroSeeder::class,
            CalendarSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
