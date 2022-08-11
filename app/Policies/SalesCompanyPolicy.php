<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class SalesCompanyPolicy
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
        return Gate::any(['viewSalesCompany', 'manageSalesCompany'], $user);
    }

    public function view($user, $post)
    {
        return Gate::any(['viewSalesCompany', 'manageSalesCompany'], $user, $post);
    }

    public function create($user)
    {
        return $user->can('manageSalesCompany');
    }

    public function update($user, $post)
    {
        return $user->can('manageSalesCompany', $post);
    }

    public function delete($user, $post)
    {
        return $user->can('manageSalesCompany', $post);
    }

    public function restore($user, $post)
    {
        return $user->can('manageSalesCompany', $post);
    }

    public function forceDelete($user, $post)
    {
        return $user->can('manageSalesCompany', $post);
    }
}
