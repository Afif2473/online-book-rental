<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;

class ResetPassword implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $user;
    public $resetToken;

    public function __construct(User $user, $resetToken)
    {
        $this->user = $user;
        $this->resetToken = $resetToken;
    }

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new ResetPasswordMail($this->user, $this->resetToken));
    }
}
