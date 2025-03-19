<?php

declare(strict_types=1);

namespace Modules\Chat\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Modules\Chat\Database\Factories\MessageFactory;

// use Modules\Chat\Database\Factories\MessageFactory;

class Message extends Model
{
    use HasFactory;

    protected $table = 'chat__messages';

    protected $fillable = [
        'user_id',
        'group_id',
        'message',
    ];

    public function groups(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function reads(): HasMany
    {
        return $this->hasMany(MessageRead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(MessageImage::class);
    }

    public function getViewMessageAttribute()
    {
        if ($this->message) {
            return $this->message;
        }

        if ($this->images) {
            return '画像が送信されました。';
        }

        return '　　';
    }

    public function getReadStatusesAttribute()
    {
        $readCount = $this->reads->filter(function ($read) {
            return $read->user_id !== Auth::id() && ! is_null($read->read_at);
        })->count();

        if ($readCount === 0) {
            return '';
        }

        return '既読' . ($readCount === 1 ? '' : $readCount);
    }

    protected static function newFactory(): MessageFactory
    {
        return MessageFactory::new();
    }
}
