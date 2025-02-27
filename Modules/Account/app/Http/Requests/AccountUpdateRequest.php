<?php

declare(strict_types=1);

namespace Modules\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'loginId' => ['required', 'string', 'unique:users,login_id,' . $this->loginId . ',login_id'],
            'name' => ['required', 'string',  'max:15'],
            'password' => ['nullable', 'confirmed', 'min:4'],
            'contractType' => ['nullable', 'string'],
            'role' => ['required', 'int'],
            'nameKana' => ['nullable', 'string', 'max:15'],
            'postCode' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'phoneNumber' => ['nullable', 'string'],
            'birthday' => ['nullable', 'string'],
            'hireDate' => ['nullable', 'string'],
            'emergencyName' => ['nullable', 'string'],
            'emergencyPhoneNumber' => ['nullable', 'string'],
            'emergencyRelationship' => ['nullable', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'loginId' => 'ログインID',
            'name' => '名前',
            'password' => 'パスワード',
            'contractType' => '契約区分',
            'role' => '管理者権限',
            'nameKana' => '名前(フリガナ)',
            'postCode' => '郵便番号',
            'address' => '住所',
            'phoneNumber' => '電話番号',
            'birthday' => '生年月日',
            'hireDate' => '入社日',
            'emergencyName' => '緊急連絡先 氏名',
            'emergencyPhoneNumber' => '緊急連絡先 電話番号',
            'emergencyRelationship' => '緊急連絡先 続柄',
        ];
    }

    public function params()
    {
        $userParams = [
            'login_id' => $this->loginId,
        ];

        if ($this->password) {
            $userParams['password'] = $this->password;
        }

        $profileParams = [
            'contract_type' => $this->contractType,
            'name' => $this->name,
            'name_kana' => $this->nameKana,
            'post_code' => $this->postCode,
            'address' => $this->address,
            'phone_number' => $this->phoneNumber,
            'birthday' => $this->birthday,
            'hire_date' => $this->hireDate,
            'emergency_name' => $this->emergencyName,
            'emergency_phone_number' => $this->emergencyPhoneNumber,
            'emergency_relationship' => $this->emergencyRelationship,
        ];

        return [
            'user' => $userParams,
            'profile' => $profileParams,
            'role' => $this->role,
        ];

    }
}
