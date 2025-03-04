<?php

declare(strict_types=1);

namespace Modules\Board\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Board\Models\BoardPost;

class EditEditor extends Component
{
    use WithFileUploads;

    public $postId;

    #[Validate('required')]
    public string $title = '';

    #[Validate('nullable', 'max:2000')]
    public string $contents = '';

    #[Validate('nullable', 'file', 'max:20000')]
    public $files = [];

    public $status;

    public function mount()
    {
        $post = BoardPost::find($this->postId);

        $this->title = $post->title;
        $this->contents = $post->contents;
        $this->status = $post->status;
    }

    #[On('submit-edit-post')]
    public function updatePost($branchStatus = false)
    {
        $this->validate();

        if ($this->status) {
            $branchStatus = true;
        }

        $post = BoardPost::updateOrCreate(
            ['id' => $this->postId],
            [
                'title' => $this->title,
                'contents' => $this->contents,
                'user_id' => Auth::id(),
                'status' => $branchStatus,
            ]
        );

        $post->saveFiles($this->files);

        return redirect()->route('board.index');
    }

    public function render()
    {
        return view('board::livewire.edit-editor');
    }
}
