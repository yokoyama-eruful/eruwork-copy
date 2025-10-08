<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire\General;

use App\Events\ChatEvent;
use App\Notifications\WebPushNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Chat\Models\Group;
use Modules\Chat\Models\Message;
use Modules\Chat\Models\MessageImage;
use Modules\Chat\Models\MessageRead;

class Editor extends Component
{
    use WithFileUploads;

    public Group $group;

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
        $this->createReadStatus($message);
        $files = $this->fileUpload($message);

        $this->dispatch('clear-editor');

        ChatEvent::dispatch();

        $this->reset(['message', 'files']);

        $this->webPush($message, $files);
    }

    private function isEmptyMessage(): bool
    {
        return $this->message === null || preg_match('/^<p>(\s|　|<br\s*\/?>)*<\/p>$/u', $this->message);
    }

    private function sendMessage(): Message
    {
        return Message::create([
            'user_id' => Auth::id(),
            'group_id' => $this->group->id,
            'message' => $this->message,
        ]);
    }

    private function webPush($message, $files)
    {
        $otherUsers = $this->group->users->reject(function ($user) {
            return $user->id === Auth::id();
        });

        $formatMessage = Auth::user()->name . ':';

        if ($message) {
            $formatMessage = $formatMessage . preg_replace('/<[^>]+>/', '', $message->message ?? '');
        }

        if ($files) {
            $formatMessage = $formatMessage . 'と' . count($files) . '件の画像';
        }

        $url = Request::getSchemeAndHttpHost() . '/app/chat/' . $this->group->id;

        foreach ($otherUsers as $user) {
            $user->notify(
                new WebPushNotification(
                    title: 'エルフルサービス',
                    message : $formatMessage,
                    image: '',
                    url: $url,
                ));
        }
    }

    private function createReadStatus($message)
    {
        $users = $this->group->users()
            ->member()
            ->get();

        $data = $users->map(function ($user) use ($message) {
            return [
                'user_id' => $user->id,
                'group_id' => $this->group->id,
                'message_id' => $message->id,
            ];
        })->toArray();

        MessageRead::insert($data);
    }

    private function fileUpload(Message $message)
    {
        $data = array_map(function ($file) use ($message) {
            $fileName = basename($file->store(path: 'chat/files/' . $message->group_id));
            $filePath = route('chat.image.show', ['groupId' => $message->group_id, 'fileName' => $fileName]);

            return [
                'message_id' => $message->id,
                'file_path' => $filePath,
            ];
        }, $this->files);

        MessageImage::insert($data);

        return $data;
    }

    public function deleteUploadFile($key)
    {
        if (isset($this->files[$key])) {
            unset($this->files[$key]);
            $this->files = array_values($this->files);
        }
    }

    public function render()
    {
        return view('chat::general.livewire.editor');
    }
}
