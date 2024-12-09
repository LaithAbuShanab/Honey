<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usernameOrEmail' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        if (!User::where('email', $value)->exists()) {
                            $fail(__('app.emailDoesNotExist'));
                        }
                    } else {
                        if (!User::where('name', $value)->exists()) {
                            $fail(__('app.urenNameDoesNotExist'));
                        }
                    }
                }
            ],
            'password' => 'required',
        ];
    }
}
