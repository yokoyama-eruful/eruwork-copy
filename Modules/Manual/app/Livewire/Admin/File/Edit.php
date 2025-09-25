<?php

declare(strict_types=1);

namespace Modules\Manual\Livewire\Admin\File;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Modules\Manual\Livewire\Admin\File\Forms\FileForm;
use Modules\Manual\Models\ManualFile;

class Edit extends Component
{
    use WithFileUploads;

    public FileForm $form;

    public ManualFile $file;

    public function mount($file)
    {
        $this->file = $file;
        $this->form->setValue($file);
    }

    #[On('edit-manual')]
    public function edit($branchStatus = '下書き')
    {
        $this->form->update($branchStatus);

        return to_route('manualFileManager.index', ['folder_id' => $this->file->folder->id]);
    }

    public function deleteFile()
    {
        if ($this->form->uploadFile && $this->judgeUploadFile($this->form->uploadFile)) {
            $this->form->uploadFile->delete();
        } else {
            $this->form->existingFile = null;
        }

        $this->form->uploadFile = null;
    }

    public function addDetail($index)
    {
        $newDetail = ['title' => '', 'content' => ''];
        array_splice($this->form->details, $index + 1, 0, [$newDetail]);
    }

    public function deleteDetail($index)
    {
        unset($this->form->details[$index]);
        $this->form->details = array_values($this->form->details);
    }

    public function addStep($index)
    {
        $newStep = ['title' => '', 'content' => '', 'file' => ''];
        array_splice($this->form->steps, $index + 1, 0, [$newStep]);
    }

    public function deleteStepFile($index)
    {
        if ($this->form->steps[$index]['file'] && $this->judgeUploadFile($this->form->steps[$index]['file'])) {
            $this->form->steps[$index]['file']->delete();
        }

        $this->form->deleteDetailFiles[] = $this->form->steps[$index]['file'];
        $this->form->steps[$index]['file'] = '';
    }

    public function deleteStep($index)
    {
        if ($this->form->steps[$index]['file']) {
            $this->deleteStepFile($index);
        }

        unset($this->form->steps[$index]);
        $this->form->steps = array_values($this->form->steps);
    }

    public function judgeUploadFile($file)
    {
        if ($file instanceof TemporaryUploadedFile) {
            return true;
        } else {
            return false;
        }
    }

    public function render()
    {
        return view('manual::admin.file.livewire.edit');
    }
}
