<?php

declare(strict_types=1);

namespace Modules\Chat\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Modules\Chat\Database\Factories\MessageFactory;

class Message extends Model
{
    use HasFactory;

    protected $table = 'chat__messages';

    protected $fillable = [
        'user_id',
        'group_id',
        'message',
        'type',
    ];

    public function groups(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function messageReads(): HasMany
    {
        return $this->hasMany(MessageRead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
