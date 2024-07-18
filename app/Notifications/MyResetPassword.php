<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class MyResetPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.my_reset_password', ['token' => $this->token])
            ->subject(trans('emails/my_reset_password_lang.subject'));
    }
}
