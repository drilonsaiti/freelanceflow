<?php

namespace App\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SubmitProposalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cover_letter' => ['required', 'string', 'max:5000'],
            'proposed_rate' => ['required', 'numeric', 'min:0'],
            'estimated_days' => ['required', 'numeric', 'min:0'],
        ];
    }

}
