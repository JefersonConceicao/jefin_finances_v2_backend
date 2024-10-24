<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailRegisterUser extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected User $user
    )
    {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'CONFIRME SEU CADASTRO',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'confirmRegisterMail',
            with: [
                'name' => $this->user->name,
                'confirmation_link' => route('auth.registerConfirmation',$this->user->mail_token_confirm)
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
