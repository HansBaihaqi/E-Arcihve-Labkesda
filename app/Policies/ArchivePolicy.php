<?php

namespace App\Policies;

use App\Models\Archive;
use App\Models\User;

class ArchivePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view archives');
    }

    public function view(User $user, Archive $archive): bool
    {
        return $user->can('view archives');
    }

    public function create(User $user): bool
    {
        return $user->can('create archives');
    }

    public function update(User $user, Archive $archive): bool
    {
        return $user->can('edit archives');
    }

    public function delete(User $user, Archive $archive): bool
    {
        return $user->can('delete archives');
    }

    public function download(User $user, Archive $archive): bool
    {
        return $user->can('download archives');
    }
}
