<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Support\Facades\URL;

class MyVerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;
    public $reciever;

    public function __construct($user)
    {
        $this->reciever = $user;
        // Aquí puedes agregar lógica que deseas ejecutar antes de que se procese cualquier solicitud
        // Por ejemplo, puedes agregar middleware específico o cualquier otra inicialización.
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->view('emails.my_verify_email', ['url' => $verificationUrl, "reciever" => $this->reciever])
            ->subject(trans('emails/my_verify_email_lang.subject'));
    }

    protected function verificationUrl($notifiable)
    {
        return   $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60), // Válida durante 60 minutos
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
