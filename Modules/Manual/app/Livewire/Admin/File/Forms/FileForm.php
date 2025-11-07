<?php

declare(strict_types=1);

namespace Modules\Manual\Livewire\Admin\File\Forms;

use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;
use Livewire\WithFileUploads;
use Modules\Manual\Models\ManualFile;
use Modules\Manual\Models\ManualFolder;

class FileForm extends Form
{
    use WithFileUploads;

    public ?ManualFolder $folder = null;

    public ?ManualFile $file = null;

    public ?string $title;

    public ?string $existingFile = null;

    public ?array $deleteDetailFiles = [];

    public $uploadFile;

    public $details = [['title' => '', 'content' => '']];

    public $steps = [['title' => '', 'content' => '', 'file' => '']];

    public function rules()
    {
        $rules = [
            'title' => ['required'],
        ];

        if (! $this->existingFile) {
            $rules['uploadFile'] = [
                'nullable',
                'mimetypes:video/mp4,video/quicktime,image/png,image/jpeg,image/jpg,image/gif,image/bmp,image/heic,image/heif',
                'max:51200',
            ];
        }

        return $rules;
    }

    public function setValue($file)
    {
        $this->file = $file;
        $this->folder = $file->folder;
        $this->title = $file->title;
        $this->details = $file->details;
        $this->steps = $file->steps;
        $this->existingFile = $file->thumbnail_path;
        if (str_contains((string) $file->type, 'video')) {
            $this->uploadFile = $file->movie_path;
        } else {
            $this->uploadFile = $file->thumbnail_path;
        }
    }

    public function create($branchStatus)
    {
        $this->validate();

        $filteredDetails = $this->filterDetails();
        $filteredSteps = $this->filterSteps();

        $baseData = [
            'title' => $this->title,
            'type' => $this->uploadFile?->getMimeType(),
            'manual__folder_id' => $this->folder->id,
            'details' => $filteredDetails,
            'steps' => $filteredSteps,
            'status' => $branchStatus,
        ];

        // ファイルある場合だけパス設定
        if ($this->uploadFile) {
            $mime = $this->uploadFile->getMimeType();
            $path = $this->uploadFile->store('manual/' . $this->folder->id);

            if (str_contains($mime, 'image')) {
                $baseData['thumbnail_path'] = $path;
            } elseif (str_contains($mime, 'video')) {
                $baseData['movie_path'] = $path;
                $baseData['thumbnail_path'] = $this->getMovieThumbnail($path);
            }
        }

        ManualFile::create($baseData);
    }

    public function update($branchStatus)
    {
        $this->validate();

        $data = [];
        if (is_null($this->existingFile) && $this->uploadFile) {
            $filePath = $this->uploadFile->store('manual/' . $this->folder->id);

            if (str_contains($this->uploadFile->getMimeType(), 'image')) {
                $data['thumbnail_path'] = $filePath;
                $data['movie_path'] = null;
                $data['type'] = $this->uploadFile->getMimeType();
            }

            if (str_contains($this->uploadFile->getMimeType(), 'video')) {
                $thumbnailRelativePath = $this->getMovieThumbnail($filePath);
                $data['thumbnail_path'] = $thumbnailRelativePath;
                $data['movie_path'] = $filePath;
                $data['type'] = $this->uploadFile->getMimeType();
            }

            Storage::delete($this->file->thumbnail_path);
        }

        $filteredDetails = $this->filterDetails();
        $filteredSteps = $this->filterSteps();

        foreach ($this->deleteDetailFiles as $deleteFile) {
            Storage::delete($deleteFile);
        }

        $data['title'] = $this->title;
        $data['details'] = $filteredDetails;
        $data['steps'] = $filteredSteps;
        $data['status'] = $branchStatus;

        $this->file->update($data);
    }

    public function delete()
    {
        Storage::delete($this->file->thumbnail_path);
        if (isset($this->file->movie_path)) {
            Storage::delete($this->file->movie_path);
        }

        foreach ($this->file->steps as $step) {
            if ($step['file']) {
                Storage::delete($step['file']);
            }
        }

        $this->file->delete();
    }

    private function getMovieThumbnail($filePath)
    {
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open(storage_path('app/' . $filePath));
        $thumbnailRelativePath = 'manual/' . pathinfo(basename($filePath), PATHINFO_FILENAME) . '.png';
        $video->frame(TimeCode::fromSeconds(1))->save(storage_path('app/' . $thumbnailRelativePath));

        return $thumbnailRelativePath;
    }

    private function filterDetails()
    {
        return array_values(array_filter(
            $this->details,
            fn ($detail) => ! empty($detail['title']) || ! empty($detail['content'])
        ));
    }

    private function filterSteps()
    {
        $filteredSteps = array_values(array_filter(
            $this->steps,
            fn ($step) => ! empty($step['title']) || ! empty($step['content']) || ! empty($step['file'])
        ));

        foreach ($filteredSteps as &$step) {
            if (! empty($step['file']) && $step['file'] instanceof TemporaryUploadedFile) {
                $step['file'] = $step['file']->store('manual/' . $this->folder->id);
            }
        }

        unset($step);

        return $filteredSteps;
    }
}
