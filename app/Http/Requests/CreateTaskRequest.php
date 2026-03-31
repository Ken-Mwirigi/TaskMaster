<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Set to true to allow anyone to use this API
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                Rule::unique('tasks')->where(function ($query) {
                    return $query->where('due_date', $this->due_date);
                })
            ],
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
        ];
    }
}