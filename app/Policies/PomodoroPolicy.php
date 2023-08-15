<?php

namespace App\Policies;

use App\Models\Pomodoro;
use App\Models\User;

class PomodoroPolicy
{
    public function view(User $user, Pomodoro $pomodoro): bool
    {
        return $user->id === $pomodoro->user_id;
    }

    public function update(User $user, Pomodoro $pomodoro): bool
    {
        return $user->id === $pomodoro->user_id;
    }

    public function delete(User $user, Pomodoro $pomodoro): bool
    {
        return $user->id === $pomodoro->user_id;
    }
}
