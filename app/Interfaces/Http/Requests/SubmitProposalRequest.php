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
            'coverLetter' => ['required', 'string', 'max:5000'],
            'proposedRate' => ['required', 'numeric', 'min:0'],
            'estimatedDays' => ['required', 'numeric', 'min:0'],
        ];
    }

}
