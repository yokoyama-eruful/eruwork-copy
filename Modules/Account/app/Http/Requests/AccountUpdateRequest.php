<?php

declare(strict_types=1);

namespace Modules\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login_id' => [
                'required',
                'string',
                Rule::unique('users', 'login_id')->ignore($this->id),
            ],
            'name' => ['required', 'string',  'max:15'],
            'password' => ['nullable', 'confirmed', 'min:4'],
            'contract_type' => ['nullable', 'string'],
            'role' => ['required', 'int'],
            'name_kana' => ['nullable', 'string', 'max:15'],
            'post_code' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'phone_number' => ['nullable', 'string'],
            'birthday' => ['nullable', 'string'],
            'hire_date' => ['nullable', 'string'],
            'emergency_name' => ['nullable', 'string'],
            'emergency_phone_number' => ['nullable', 'string'],
            'emergency_relationship' => ['nullable', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'login_id' => 'ログインID',
            'name' => '名前',
            'password' => 'パスワード',
            'contract_type' => '契約区分',
            'role' => '管理者権限',
            'name_kana' => '名前(フリガナ)',
            'post_code' => '郵便番号',
            'address' => '住所',
            'phone_number' => '電話番号',
            'birthday' => '生年月日',
            'hire_date' => '入社日',
            'emergency_name' => '緊急連絡先 氏名',
            'emergency_phone_number' => '緊急連絡先 電話番号',
            'emergency_relationship' => '緊急連絡先 続柄',
        ];
    }

    public function params()
    {
        $userParams = [
            'login_id' => $this->login_id,
        ];

        if ($this->password) {
            $userParams['password'] = $this->password;
        }

        $profileParams = [
            'contract_type' => $this->contract_type,
            'name' => $this->name,
            'name_kana' => $this->name_kana,
            'post_code' => $this->post_code,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'birthday' => $this->birthday,
            'hire_date' => $this->hire_date,
            'emergency_name' => $this->emergency_name,
            'emergency_phone_number' => $this->emergency_phone_number,
            'emergency_relationship' => $this->emergency_relationship,
        ];

        return [
            'user' => $userParams,
            'profile' => $profileParams,
            'role' => $this->role,
        ];

    }
}
