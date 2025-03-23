<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Models\Profile;
use Modules\Chat\Models\Group;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\WorkTime;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,HasPushSubscriptions,HasRoles,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'login_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function scopeMember($query)
    {
        return $query->where('user_id', '!=', Auth::id());
    }

    public function getNameAttribute()
    {
        return $this->profile?->name ?? 'No name';
    }

    public function getIconAttribute()
    {
        return $this->profile?->icon;
    }

    public function workTime(): HasMany
    {
        return $this->hasMany(WorkTime::class);
    }

    public function breakTime(): HasMany
    {
        return $this->hasMany(BreakTime::class);
    }

    public function groups(): BelongsToMany
    {
        return $this
            ->belongsToMany(Group::class, 'chat__group_user', 'user_id', 'group_id');
    }
}
