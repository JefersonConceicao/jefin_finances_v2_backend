<?php

namespace App\Jobs;

use App\Mail\RecoveryPassword;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMailRecoveryPassword implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected User $user
    )
    {}

    public function handle(): void
    {
        Mail::to('jefersonmallone2000@outlook.com')
        ->send(new RecoveryPassword($this->user));
    }
}
