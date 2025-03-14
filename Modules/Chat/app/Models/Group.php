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

    public function reads()
    {
        return $this->hasMany(MessageRead::class, 'group_id');
    }

    public function getNameLabelAttribute()
    {
        $usersLabel =
        $this->users->where('id', '!=', Auth::id())
            ->pluck('name')
            ->implode(',');

        return $this->name ?? $usersLabel;
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

    public function getGroupNotificationCountAttribute()
    {
        return $this->reads->filter(function ($read) {
            return $read->user_id === Auth::id() && is_null($read->read_at);
        })->count();
    }

    public function getCountUserAttribute()
    {
        return $this->users->count();
    }
}
