<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // ['board_id', 'column_id', 'title', 'description', 'priority', 'due_date', 'is_archived']

        $method = $this->method();

        switch ($method) {
            case 'POST':
                return [
                    // 'board_id'      => 'required|exists:boards,id',
                    'column_id'     => 'required|exists:columns,id',
                    'title'         => 'required|string|max:255',
                    'description'   => 'nullable|string',
                    'priority'      => 'required|in:Low,Medium,High,Urgent',
                    'due_date'      => 'nullable|date',
                    'is_archived'   => 'nullable|boolean',
                    'assignee_ids'  => 'nullable|array',
                    'assignee_ids.*' => 'exists:users,id',
                ];

            case 'PUT':
                return [
                    'title'       => 'sometimes|string|max:255',
                    'description' => 'sometimes|string',
                    'priority'    => 'nullable|in:Low,Medium,High,Urgent',
                    'due_date'    => 'nullable|date',
                ];

            case 'GET':
            case 'DELETE':
                return [];

            default:
                return [];
        }
    }
}
