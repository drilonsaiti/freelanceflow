<?php

namespace App\Interfaces\Http\Requests;

use App\Domain\Identity\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

final class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:120',
            /*            'email' => 'required|string|email:rfc,dns|max:190|unique:users,email',
*/
            'email' => 'required|string|max:190|unique:users,email',
            'password' => ['required','string',Password::min(8)->letters()->numbers(),'confirmed'],
            'role' => ['sometimes', new Enum(UserRole::class)],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge(['email' => mb_strtolower((string) $this->input('email'))]);
        }
    }
}
