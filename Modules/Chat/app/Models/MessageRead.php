<?php

declare(strict_types=1);

namespace Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Chat\Database\Factories\MessageReadFactory;

class MessageRead extends Model
{
    use HasFactory;

    protected $table = 'chat__message_images';

    const UPDATED_AT = null;

    protected $fillable = [
        'message_id',
        'file_path',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
