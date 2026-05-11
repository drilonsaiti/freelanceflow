<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:190'],
            'description' => ['nullable', 'string', 'max:190'],
            'budgetMin' => ['nullable', 'numeric', 'min:0'],
            'budgetMax' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:draft,open,in_progress,completed,cancelled'],
            'visibility' => ['required', 'string', 'in:public,private,invite_only'],
            'category' => ['nullable', 'string', 'max:190'],
            'required_skills' => ['nullable', 'array'],
            'deadline' => ['nullable', 'date'],
        ];
    }
}
