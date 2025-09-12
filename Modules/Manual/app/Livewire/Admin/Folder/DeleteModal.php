<?php

declare(strict_types=1);

namespace Modules\Manual\Livewire\Admin\Folder;

use Livewire\Component;
use Modules\Manual\Livewire\Admin\Folder\Forms\FolderForm;
use Modules\Manual\Models\ManualFolder;

class DeleteModal extends Component
{
    public FolderForm $form;

    public ManualFolder $folder;

    public function delete()
    {
        $this->form->folder = $this->folder;

        $this->form->delete();

        return to_route('manualFolderManager.index');
    }

    public function render()
    {
        return view('manual::admin.folder.livewire.delete-modal');
    }
}
