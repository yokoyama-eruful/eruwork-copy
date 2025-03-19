<?php

declare(strict_types=1);

namespace Modules\Board\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Board\Models\BoardPost;

class CreateEditor extends Component
{
    use WithFileUploads;

    public string $tenantId = '';

    #[Validate('required')]
    public string $title = '';

    #[Validate('nullable', 'max:2000')]
    public string $contents = '';

    #[Validate('nullable', 'file', 'max:20000')]
    public $files = [];

    #[On('submit-post')]
    public function submitPost($branchStatus = '下書き')
    {
        $this->validate();
        $post = BoardPost::create([
            'title' => $this->title,
            'contents' => $this->contents,
            'user_id' => Auth::id(),
            'status' => $branchStatus,
        ]);

        $post->viewers()
            ->sync(User::get());

        $post->saveFiles($this->files);

        return redirect()->route('board.index');
    }

    public function render()
    {
        return view('board::livewire.create-editor');
    }
}
