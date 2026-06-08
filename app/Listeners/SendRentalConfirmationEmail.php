<?php

namespace App\Listeners;

use App\Events\RentalRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\RentalRequestedMail;

class SendRentalConfirmationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RentalRequested $event): void
    {
        $rental = $event->rental;
        Mail::to($rental->user->email)->send(new RentalRequestedMail($rental));
    }
}
