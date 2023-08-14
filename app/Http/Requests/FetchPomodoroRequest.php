<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FetchPomodoroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pomodoro' => 'required|exists:pomodoros,id',
        ];
    }
}
