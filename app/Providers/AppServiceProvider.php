<?php

namespace App\Providers;

use App\Nova\Post;
use App\Nova\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Nova\Nova;

use App\Observers\MobileAppUserObserver;
use App\Models\MobileAppUser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::resources([
            User::class,
            Post::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        /**
         * This observer used for send confimation email
         *
         * @return 
         */
        MobileAppUser::observe(MobileAppUserObserver::class);
    }
}
