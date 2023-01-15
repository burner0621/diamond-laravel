<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, User $other_user)
    {
        return $user->id == $other_user->id;
    }

    public function seeInfo(User $user, User $other_user)
    {
        return self::edit($user, $other_user)
            || $user->role;
    }
}
