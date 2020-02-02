<?php

namespace App\Mail\Auth;

use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Signup Confirmation')
            ->markdown('emails.auth.register.verify')
            ->with(['user' => $this->user]);
    }
}
