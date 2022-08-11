<?php

namespace App\Observers;

use App\Models\MobileAppUser;

use App\Mail\MobileUserCreate;
use Illuminate\Support\Facades\Mail;

class MobileAppUserObserver
{
    /**
     * Handle the MobileAppUser "created" event.
     *
     * @param  \App\Models\MobileAppUser  $mobileAppUser
     * @return void
     */
    public function created(MobileAppUser $mobileAppUser)
    {
        Mail::to($mobileAppUser->email)->send(new MobileUserCreate($mobileAppUser));
    }

    /**
     * Handle the MobileAppUser "updated" event.
     *
     * @param  \App\Models\MobileAppUser  $mobileAppUser
     * @return void
     */
    public function updated(MobileAppUser $mobileAppUser)
    {
        //
    }

    /**
     * Handle the MobileAppUser "deleted" event.
     *
     * @param  \App\Models\MobileAppUser  $mobileAppUser
     * @return void
     */
    public function deleted(MobileAppUser $mobileAppUser)
    {
        //
    }

    /**
     * Handle the MobileAppUser "restored" event.
     *
     * @param  \App\Models\MobileAppUser  $mobileAppUser
     * @return void
     */
    public function restored(MobileAppUser $mobileAppUser)
    {
        //
    }

    /**
     * Handle the MobileAppUser "force deleted" event.
     *
     * @param  \App\Models\MobileAppUser  $mobileAppUser
     * @return void
     */
    public function forceDeleted(MobileAppUser $mobileAppUser)
    {
        //
    }
}
