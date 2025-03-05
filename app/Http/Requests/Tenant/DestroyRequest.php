<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

final class DestroyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        Validator::extend('custom_rule', function ($attribute, $value, $parameters, $validator) {
            return $this->input('delete_tenant_id') == $this->input('tenant_id');
        });

        return [
            'delete_tenant_id' => ['required', 'custom_rule'],
        ];
    }

    public function attributes()
    {
        return [
            'delete_tenant_id' => '削除用文字列',
        ];
    }

    public function messages()
    {
        return [
            'delete_tenant_id.custom_rule' => '削除用文字列が一致しません。',
        ];
    }
}
