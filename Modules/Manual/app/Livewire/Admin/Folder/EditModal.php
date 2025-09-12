<?php

declare(strict_types=1);

namespace Modules\Manual\Livewire\Admin\Folder;

use Livewire\Component;
use Modules\Manual\Livewire\Admin\Folder\Forms\FolderForm;
use Modules\Manual\Models\ManualFolder;

class EditModal extends Component
{
    public FolderForm $form;

    public ManualFolder $folder;

    public function openModal(int $folderId)
    {
        $this->form->setValue($folderId);
        $this->dispatch('open-modal', 'manual-folder-edit-modal-' . $folderId);
    }

    public function edit()
    {
        $this->form->update();

        return to_route('manualFolderManager.index');
    }

    public function render()
    {
        return view('manual::admin.folder.livewire.edit-modal');
    }
}
