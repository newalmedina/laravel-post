<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userCreated;
    public $password;
    public $setting;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userCreated,$password)
    {
        $this->userCreated = $userCreated;
        $this->password = $password;
        $this->setting =\App\Services\SettingsServices::getGeneral();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $siteName= !empty($this->setting->site_name)?$this->setting->site_name:config('app.name');

        return $this->subject( trans('emails/user_created_lang.subject',["plataformaName"=>  $siteName]) )
                    ->view('emails.user_created_email'); // Puedes personalizar la vista según tus necesidades
    }
}
