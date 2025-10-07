<?php

declare(strict_types=1);

namespace Modules\Manual\Livewire\Admin\File;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Manual\Livewire\Admin\File\Forms\FileForm;
use Modules\Manual\Models\ManualFolder;

class Create extends Component
{
    use WithFileUploads;

    public FileForm $form;

    public ManualFolder $folder;

    public function mount($folderId)
    {
        $folder = ManualFolder::find($folderId);
        $this->folder = $folder;
        $this->form->folder = $folder;
    }

    public function create($branchStatus = '下書き')
    {
        $this->form->create($branchStatus);

        return to_route('manualFileManager.index', ['folder_id' => $this->folder->id]);
    }

    public function deleteFile()
    {
        if ($this->form->file) {
            $this->form->file->delete();
        }

        $this->form->file = null;
    }

    public function deleteUploadFile()
    {
        if ($this->form->uploadFile) {
            $this->form->uploadFile->delete();
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
        if ($this->form->steps[$index]['file']) {
            $this->form->steps[$index]['file']->delete();
        }

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

    public function render()
    {
        return view('manual::admin.file.livewire.create');
    }
}
