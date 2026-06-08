<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Rental;

use App\Notifications\RentalExpiringSoon;
use App\Notifications\RentalExpiryToday;

#[Signature('app:send-expiry-notifications')]
#[Description('Command description')]
class SendExpiryNotifications extends Command
{
    protected $signature;
    protected $description;

    public function handle()
    {
        /*$expiringDate = Carbon::today()->addDays(3);
        $rentalsExpiring = Rental::where('status', 'Picked Up')
            ->whereDate('expires_at', $expiringDate)
            ->get();
            
        foreach ($rentalsExpiring as $rental)
        {
            $rental->user->notify(new \App\Notifications\RentalExpiringSoon($rental));
        }*/

        $expiringDate = Carbon::today()->addDays(3);
        $rentalExpiring = Rental::where('status', 'Picked Up')
            ->whereDate('expires_at', $expiringDate)
            ->get();
        foreach ($rentalExpiring as $rental)
        {
            Mail::to($rental->user)->send(new \App\Mail\RentalExpireSoon($rental, 'expiring soon'));
        }

        $expiredToday = Carbon::today();
        $rentalsToday = Rental::where('status', 'Picked Up')
            ->whereDate('expires_at', $expiredToday)
            ->get();
        foreach ($rentalsToday as $rental)
        {
            Mail::to($rental->user)->send(new \App\Mail\RentalExpireToday($rental, 'expired today'));        
        }

        $expired = Carbon::today()->subDay();
        $rentalsExpired = Rental::where('status', 'Picked Up')
            ->whereDate('expires_at', '<=', $expired)
            ->get();
        $this->info("Found " . $rentalsExpired->count() . " rentals to mark as expired.");
        foreach ($rentalsExpired as $rental)
        {
            $rental->update(['status' => 'expired']);
            $rental->book->increment('quantity');
        }
    }   
}
