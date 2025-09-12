<?php

declare(strict_types=1);

namespace Modules\Manual\Livewire\Admin\Folder;

use Livewire\Component;
use Modules\Manual\Livewire\Admin\Folder\Forms\FolderForm;

class CreateModal extends Component
{
    public FolderForm $form;

    public function create()
    {
        $this->form->store();

        return to_route('manualFolderManager.index');
    }

    public function render()
    {
        return view('manual::admin.folder.livewire.create-modal');
    }
}
