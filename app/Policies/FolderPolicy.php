<?php

namespace App\Policies;

use App\Models\Folder;
use App\Models\User;

class FolderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'Super Admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['Admin', 'Super Admin']);
    }
}
