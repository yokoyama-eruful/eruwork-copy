<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Chat\Models\Message;
use Modules\Chat\Models\MessageImage;

class Editor extends Component
{
    use WithFileUploads;

    public $groupId;

    public $message;

    #[Validate(
        ['files.*' => 'file|mimes:jpg,jpeg,png,gif,bmp,webp,heic,heif|max:10240'],
        message: ['mimes' => 'アップロードできるのは（jpg,jpeg,png,gif,bmp,webp,heic,heif）のみです。'],
    )]
    public array $files = [];

    public function store()
    {
        if ($this->isEmptyMessage() && empty($this->files)) {
            return;
        }

        $message = $this->sendMessage();
        $this->fileUpload($message);

        $this->reset(['message', 'files']);
    }

    private function isEmptyMessage(): bool
    {
        return $this->message === null || preg_match('/^<p>(\s|　|<br\s*\/?>)*<\/p>$/u', $this->message);
    }

    private function sendMessage(): Message
    {
        return Message::create([
            'user_id' => Auth::id(),
            'group_id' => $this->groupId,
            'message' => $this->message,
        ]);
    }

    private function fileUpload(Message $message)
    {
        $data = array_map(function ($file) use ($message) {
            $fileName = basename($file->store(path: 'chat/files'));
            $filePath = route('chat.image.show', ['fileName' => $fileName]);

            return [
                'message_id' => $message->id,
                'file_path' => $filePath,
            ];
        }, $this->files);

        MessageImage::insert($data);
    }

    public function render()
    {
        return view('chat::livewire.editor');
    }
}
