<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny($user)
    {
        return Gate::any(['viewEmployee', 'manageEmployee'], $user);
    }

    public function view($user, $post)
    {
        return Gate::any(['viewEmployee', 'manageEmployee'], $user, $post);
    }

    public function create($user)
    {
        return $user->can('manageEmployee');
    }

    public function update($user, $post)
    {
        return $user->can('manageEmployee', $post);
    }

    public function delete($user, $post)
    {
        return $user->can('manageEmployee', $post);
    }

    public function restore($user, $post)
    {
        return $user->can('manageEmployee', $post);
    }

    public function forceDelete($user, $post)
    {
        return $user->can('manageEmployee', $post);
    }
}
