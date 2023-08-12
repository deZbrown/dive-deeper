<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePomodoroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_id' => 'required|exists:tasks,id',
            'duration' => 'required|integer|min:1',
        ];
    }
}
