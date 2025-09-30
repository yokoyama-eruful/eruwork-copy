<?php

declare(strict_types=1);

namespace Modules\Manual\Livewire\Admin\File;

use Livewire\Component;
use Modules\Manual\Livewire\Admin\File\Forms\FileForm;
use Modules\Manual\Models\ManualFile;
use Modules\Manual\Models\ManualFolder;

class DeleteModal extends Component
{
    public FileForm $form;

    public ManualFolder $folder;

    public ManualFile $file;

    public function mount($folderId)
    {
        $folder = ManualFolder::find($folderId);
        $this->folder = $folder;
    }

    public function delete()
    {
        $this->form->file = $this->file;

        $this->form->delete();

        return to_route('manualFileManager.index', ['folder_id' => $this->folder->id]);
    }

    public function render()
    {
        return view('manual::admin.file.livewire.delete-modal');
    }
}
