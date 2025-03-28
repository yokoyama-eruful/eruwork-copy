<?php

declare(strict_types=1);

namespace Modules\Board\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\Board\Models\BoardLike;

class Like extends Component
{
    public int $postId;

    public int $likeCount = 0;

    public function mount(): void
    {
        $this->likeCount = $this->getLikeCount();
    }

    public function getLikeCount(): int
    {
        return BoardLike::where('post_id', $this->postId)->count();
    }

    public function getLikeStatus(): void
    {
        $like = new BoardLike;
        $like->favorite($this->postId);

        $this->likeCount = $this->getLikeCount();
    }

    public function judgeLike()
    {
        $like = BoardLike::where('user_id', Auth::id())
            ->where('post_id', $this->postId)
            ->first();

        return $like;
    }

    #[Computed()]
    public function likes()
    {
        return BoardLike::where('post_id', $this->postId)->get();
    }

    public function render()
    {
        return view('board::livewire.like');
    }
}
