<?php

declare(strict_types=1);

namespace Modules\Chat\Policies;

use App\Models\User;
use Modules\Chat\Models\Group;

class ChatGroupPolicy
{
    public function view(User $user, Group $group): bool
    {
        return $group->users()->where('users.id', $user->id)->exists();
    }
}
