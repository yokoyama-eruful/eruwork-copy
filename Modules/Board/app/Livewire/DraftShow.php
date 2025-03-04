<?php

declare(strict_types=1);

namespace Modules\Board\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Board\Models\BoardPost;

class DraftShow extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $posts = BoardPost::where('status', false)
            ->where('user_id', Auth::id())
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('title', 'like', '%' . $this->search . '%');
                }
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('board::livewire.draft-show', ['posts' => $posts]);
    }
}
