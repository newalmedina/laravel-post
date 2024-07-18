<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Center;
class OthersUserCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userCreated;
    public $password;
    public $setting;
    public $center;
    public $reciever;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userCreated,$password,$reciever)
    {
        $this->userCreated = $userCreated;
        $this->password = $password;
        $this->reciever = $reciever;
        $this->setting =\App\Services\SettingsServices::getGeneral();
        $this->center =Center::find($this->userCreated->userProfile->created_center);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $siteName= !empty($this->setting->site_name)?$this->setting->site_name:config('app.name');

        return $this->subject( trans('emails/other_user_created_lang.subject',["plataformaName"=>  $siteName]) )
                    ->view('emails.other_user_created_email'); // Puedes personalizar la vista según tus necesidades
    }
}
