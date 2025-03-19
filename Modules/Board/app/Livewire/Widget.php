<?php

declare(strict_types=1);

namespace Modules\Board\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Board\Models\BoardPost;

class Widget extends Component
{
    public Collection $posts;

    public function mount()
    {
        $this->posts =
            BoardPost::where('status', '掲載')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
    }

    public function readStatus($post)
    {
        $user = Auth::user();

        return
            $post->viewers()
                ->where('user_id', $user->id)
                ->first()
                ?->pivot
                ->read_at;
    }

    public function read(int $postId)
    {
        return to_route('board.board.show', ['id' => $postId]);
    }

    public function render()
    {
        return view('board::livewire.widget');
    }
}
