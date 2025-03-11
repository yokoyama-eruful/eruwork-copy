<?php

declare(strict_types=1);

namespace Modules\Chat\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

// use Modules\Chat\Database\Factories\GroupFactory;

class Group extends Model
{
    use HasFactory;

    protected $table = 'chat__groups';

    protected $fillable = [
        'is_dm',
        'name',
        'icon',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat__group_user', 'group_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'group_id');
    }

    public function getIconImageAttribute(): ?string
    {
        if ($this->is_dm) {
            $partnerUser = $this->users->firstWhere('id', '!=', Auth::id());

            return $partnerUser?->icon;
        }

        return $this->icon ?? '';
    }

    public function getLastMessageAttribute()
    {
        return $this->messages->sortByDesc('created_at')->first();
    }
}
