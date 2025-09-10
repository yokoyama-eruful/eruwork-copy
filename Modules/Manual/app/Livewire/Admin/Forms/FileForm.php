<?php

declare(strict_types=1);

namespace Modules\Manual\Livewire\Admin\Forms;

use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use Modules\Manual\Models\ManualFile;
use Modules\Manual\Models\ManualFolder;

class FileForm extends Form
{
    use WithFileUploads;

    public ?ManualFolder $folder;

    #[Validate('required')]
    public ?string $title;

    #[Validate('required|mimetypes:video/mp4,video/quicktime,image/png,image/jpeg,image/jpg,image/gif,image/bmp,image/heic,image/heif|max:51200')]
    public $file;

    public $details = [['title' => '', 'content' => '']];

    public function create()
    {
        $this->validate();

        $data = [];

        $filteredDetails = array_values(array_filter(
            $this->details,
            fn ($detail) => ! empty($detail['title']) || ! empty($detail['content'])
        ));

        $filePath = $this->file->store('manual');

        if (str_contains($this->file->getMimeType(), 'image')) {
            $data = [
                'title' => $this->title,
                'thumbnail_path' => $filePath,
                'type' => $this->file->getMimeType(),
                'manual__folder_id' => $this->folder->id,
                'details' => $filteredDetails,
            ];
        }

        if (str_contains($this->file->getMimeType(), 'video')) {
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open(storage_path('app/' . $filePath));
            $thumbnailRelativePath = 'manual/' . pathinfo(basename($filePath), PATHINFO_FILENAME) . '.png';
            $video->frame(TimeCode::fromSeconds(1))->save(storage_path('app/' . $thumbnailRelativePath));

            $data = [
                'title' => $this->title,
                'thumbnail_path' => $thumbnailRelativePath,
                'movie_path' => $filePath,
                'type' => $this->file->getMimeType(),
                'manual__folder_id' => $this->folder->id,
                'details' => $filteredDetails,
            ];
        }

        if (! empty($data)) {
            ManualFile::create($data);
        }
    }
}
