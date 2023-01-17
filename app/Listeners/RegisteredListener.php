<?php

namespace App\Listeners;

use App\Jobs\SendWelcomeEmail;
use App\Mail\WelcomMail;
use Carbon\Carbon;
use Mail;

class RegisteredListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //send the welcome email to the user
        $user = $event->user;
        $job = (new SendWelcomeEmail($user))->delay(Carbon::now()->addMinutes(1));
        dispatch($job);
    }
}
