<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use App\Mail\MobileUserCreate;
use Illuminate\Support\Facades\Mail;

class EmailSendOnMobileUserCreate extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        
        //loop over the orders that have been selected in nova
        foreach ($models as $key => $mbl_user) {
            // echo "<pre>"; var_dump($mbl_user); echo "</pre>";
            // $employee = $mbl_user->contract; //however you are getting contract data
            //assuming you have a $order->user  order belongs to user relationship
            //send mail to the user, with the order/contract details to create your email
            Mail::to($mbl_user->email)->send(new MobileUserCreate((object) $mbl_user));
        }
        //return a message to nova
        return Action::message('Mail envoyé');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
