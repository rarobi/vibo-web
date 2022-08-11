<?php

namespace App\Providers;

use App\Models\CustomerAdmin;
use App\Models\Employee;
use App\Models\Post;
use App\Models\SalesAdmin;
use App\Models\SalesCompany;
use App\Policies\CustomerAdminPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\PostPolicy;
use App\Policies\SalesAdminPolicy;
use App\Policies\SalesCompanyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Silvanite\Brandenburg\Traits\ValidatesPermissions;

class AuthServiceProvider extends ServiceProvider
{
    use ValidatesPermissions;
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        SalesAdmin::class => SalesAdminPolicy::class,
        CustomerAdmin::class => CustomerAdminPolicy::class,
        Employee::class => EmployeePolicy::class,
        SalesCompany::class => SalesCompanyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        collect([
            'viewPost',
            'managePost',
            'viewSalesAdmin',
            'manageSalesAdmin',
            'viewCustomerAdmin',
            'manageCustomerAdmin',
            'viewEmployee',
            'manageEmployee',
            'viewSalesCompany',
            'manageSalesCompany',
        ])->each(function($permission){
            Gate::define($permission,function($user) use($permission){
                if($this->nobodyHasAccess($permission)){
                    return false;
                }

                return $user->hasRoleWithPermission($permission);
            });
        });

        $this->registerPolicies();

        //
    }
}
