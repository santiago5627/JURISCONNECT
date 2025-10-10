<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;

class SendCredentialsToLawyer extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plainPassword;
    public $resetUrl;

    public function __construct($user, $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;

        $token = Password::createToken($user);
        $this->resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($user->email));
    }

    public function build()
    {
        return $this->subject('Tus credenciales de acceso a JustConnect SENA')
                    ->view('emails.send-credentials')
                    ->with([
                        'user' => $this->user,
                        'plainPassword' => $this->plainPassword,
                        'resetUrl' => $this->resetUrl,
                    ]);
    }
}
