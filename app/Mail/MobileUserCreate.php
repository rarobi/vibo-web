<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MobileAppUser;

class MobileUserCreate extends Mailable
{
    use Queueable, SerializesModels;

    public $mbl_user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MobileAppUser $mbl_user)
    {
        $this->mbl_user = $mbl_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // echo "<pre>"; var_dump($this->mbl_user); echo "</pre>";
        return $this->subject('User create confirmation')->view('emails.mobile_user_confirmation_email');
    }
}
