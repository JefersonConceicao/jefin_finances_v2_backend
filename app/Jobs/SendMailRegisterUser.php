<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;

use App\Mail\SendMailRegisterUser as SendMailRegisterUserMail;
use Illuminate\Support\Facades\Mail;

class SendMailRegisterUser implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $user
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to('jefersonmallone2000@outlook.com')
        ->send(mailable: new SendMailRegisterUserMail($this->user));
    }
}
