<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Rental;

#[Signature('app:approve-all-requests')]
#[Description('Approve all pending rental requests')]
class approveAllRequests extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingRequests = Rental::where('status', 'pending')->get();

        foreach ($pendingRequests as $request) {
            $request->status = 'approved';
            $request->save();
        }
        $this->info('All pending rental requests have been approved.');
    }
}
