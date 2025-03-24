<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class UserSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'icon' => ['nullable', 'image'],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'new_password.confirmed' => '新しいパスワードと確認用パスワードが一致しません',
        ];
    }

    public function attributes()
    {
        return [
            'new_password' => '新しいパスワード',
        ];
    }

    public function checkPassword(): void
    {
        if (! Hash::check($this->current_password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'error' => '現在のパスワードが正しくありません',
            ]);
        }
    }
}
