<?php

declare(strict_types=1);

namespace Modules\Board\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\Board\Models\BoardAttachment;
use Modules\Board\Models\BoardPost;

class Download extends Component
{
    public ?BoardPost $post;

    public bool $canBeDeleted = false;

    public function render()
    {
        return view('board::livewire.download');
    }

    public function deleteFile($fileID)
    {
        $file = BoardAttachment::find($fileID);

        Storage::delete($file->file_path);

        $file->delete();
    }

    #[Computed]
    public function files()
    {
        return BoardAttachment::where('post_id', $this->post?->id)->get();
    }

    public function stringTruncate($string)
    {
        if (mb_strlen($string) > 30) {
            $start = mb_substr($string, 0, 15);
            $end = mb_substr($string, -15);
            $middle = '...';
        } else {
            $start = $string;
            $middle = '';
            $end = '';
        }

        return $start . $middle . $end;
    }
}
