<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'phone_number' => ['nullable', 'regex:/^[0-9]{10,15}$/'],
            'email' => ['nullable', 'email'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => '施設名',
            'phone_number' => '電話番号',
            'email' => 'メールアドレス',
        ];
    }
}
