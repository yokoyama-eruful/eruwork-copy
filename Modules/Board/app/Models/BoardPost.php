<?php

declare(strict_types=1);

namespace Modules\Board\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Modules\Board\Database\Factories\BoardPostFactory;

// use Modules\Board\Database\Factories\BoardPostFactory;

class BoardPost extends Model
{
    use HasFactory;

    protected $table = 'board__posts';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'contents',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(BoardAttachment::class, 'post_id');
    }

    public function viewers(): BelongsToMany
    {
        return
            $this->belongsToMany(User::class, 'board__post_read_statuses', 'post_id')
                ->withPivot(['user_id', 'read_at']);
    }

    public function canEdit()
    {
        return $this->user_id == Auth::id();
    }

    public function saveFiles(?array $files): void
    {
        if (empty($files)) {
            return;
        }

        foreach ($files as $file) {
            $fileList[] = [
                'post_id' => $this->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $this->fileUpload($file),
            ];
        }

        $this->attachments()->createMany($fileList);
    }

    public function getReadStatusAttribute()
    {
        return $this->viewers()->where('user_id', Auth::id())->first()?->pivot->read_at;
    }

    private function fileUpload($uploadFile): string
    {
        if (isset($uploadFile)) {
            $filePath = $uploadFile->store(path: 'board/files');

            return $filePath;
        }

        return '';
    }

    protected static function newFactory(): BoardPostFactory
    {
        return BoardPostFactory::new();
    }
}
