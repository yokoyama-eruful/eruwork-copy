<?php

declare(strict_types=1);

namespace Modules\Manual\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManualFile extends Model
{
    use HasFactory;

    protected $table = 'manual__files';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'user_id',
        'thumbnail_path',
        'movie_path',
        'type',
        'manual__folder_id',
        'details',
        'steps',
        'status',
    ];

    protected $casts = [
        'details' => 'array',
        'steps' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function folder()
    {
        return $this->belongsTo(ManualFolder::class, 'manual__folder_id');
    }
}
