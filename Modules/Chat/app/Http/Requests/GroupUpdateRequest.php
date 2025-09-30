<?php

declare(strict_types=1);

namespace Modules\Chat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $groupId = $this->route('group')?->id;

        return [
            'icon' => ['nullable', 'image'],
            'name' => [
                'required',
                'string',
                Rule::unique('chat__groups', 'name')->ignore($groupId),
            ],
            'member' => ['required'],
        ];
    }
}
