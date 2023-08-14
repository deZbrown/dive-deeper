<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePomodoroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'duration' => 'sometimes|required|integer|min:1',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after_or_equal:start_time',
        ];
    }
}
