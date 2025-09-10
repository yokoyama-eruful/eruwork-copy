<?php

declare(strict_types=1);

namespace Modules\Manual\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Manual\Livewire\Admin\Forms\FileForm;
use Modules\Manual\Models\ManualFolder;

class Create extends Component
{
    use WithFileUploads;

    public FileForm $form;

    public ManualFolder $folder;

    public function mount($folder)
    {
        $this->folder = $folder;
        $this->form->folder = $folder;
    }

    public function create()
    {
        $this->form->create();

        return to_route('manualFileManager.index', ['folder_id' => $this->folder->id]);
    }

    public function deleteFile()
    {
        if ($this->form->file) {
            $this->form->file->delete();
        }

        $this->form->file = null;
    }

    public function addDetail()
    {
        $this->form->details[] = ['title' => '', 'content' => ''];
    }

    public function render()
    {
        return view('manual::admin.file.livewire.create');
    }
}
