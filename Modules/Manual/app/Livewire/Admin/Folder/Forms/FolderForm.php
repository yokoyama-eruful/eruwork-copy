<?php

declare(strict_types=1);

namespace Modules\Manual\Livewire\Admin\Folder\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Modules\Manual\Models\ManualFolder;

class FolderForm extends Form
{
    public ?ManualFolder $folder;

    #[Validate('required')]
    public ?string $title;

    public function setValue($folderId)
    {
        $this->folder = ManualFolder::find($folderId);
        $this->title = $this->folder->title;
    }

    public function store()
    {
        $this->validate();

        $manualFolder = ManualFolder::create([
            'title' => $this->title,
            'user_id' => Auth::id(),
        ]);

        Storage::makeDirectory('manual/' . $manualFolder->id);
    }

    public function update()
    {
        $this->validate();

        $this->folder->update([
            'title' => $this->title,
        ]);
    }

    public function delete()
    {
        Storage::deleteDirectory('manual/' . $this->folder->id);

        $this->folder->delete();
    }
}
