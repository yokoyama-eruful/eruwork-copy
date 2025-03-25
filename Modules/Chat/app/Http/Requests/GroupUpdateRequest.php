<?php

declare(strict_types=1);

namespace Modules\Chat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'icon' => ['nullable', 'image'],
            'name' => ['required', 'string', 'unique:chat__groups,name,' . $this->id . ',id'],
            'member' => ['required'],
        ];
    }
}
