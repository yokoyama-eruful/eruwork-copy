<?php

declare(strict_types=1);

namespace Modules\Board\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

// use Modules\Board\Database\Factories\BoardPostFactory;

class BoardLike extends Model
{
    use HasFactory;

    protected $table = 'board__likes';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function favorite($postID)
    {
        $userID = Auth::id();
        $like = self::where('user_id', $userID)
            ->where('post_id', $postID)
            ->first();

        if (! $like) {
            self::create([
                'user_id' => Auth::id(),
                'post_id' => $postID,
            ]);

        } else {
            $like->delete([
                'user_id' => Auth::id(),
                'post_id' => $postID,
            ]);
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
