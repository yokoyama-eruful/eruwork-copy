<?php

declare(strict_types=1);

namespace Modules\Board\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class PostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'contents' => ['required', 'max:2000'],
            'files.*' => ['nullable', 'max:20000'],
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'contents' => '本文',
            'files.' => 'ファイル',
        ];
    }

    public function params(): array
    {
        return [
            'title' => $this->title,
            'contents' => $this->contents,
            'files' => $this->file('files'),
        ];
    }
}
