<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedEmail;
use App\Mail\OthersUserCreatedEmail;
use App\Models\User;

class SendUserRegistrationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userCreated;
    public $password;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userCreated,$password)
    {
        $this->userCreated=$userCreated;
        $this->password=$password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

       Mail::to($this->userCreated->email)->send(new UserCreatedEmail($this->userCreated,$this->password));
 
    
        //enviando mails de aviso de usuarios registrados a lo que tienen permisos y check
        $users=User::select(
            "users.*"
        )
        ->active()
        ->allowRecieveEmails()
        ->leftJoin("role_user","role_user.user_id","users.id")
        ->leftJoin("user_profiles","user_profiles.user_id","users.id")
        ->leftJoin("permission_role","permission_role.role_id","role_user.role_id")
        ->leftJoin("permissions","permission_role.permission_id","permissions.id")
     
        ->where("permissions.name","admin-users-mail-user-created")
        ->distinct()
        ->get();

        // dd($users);
        foreach ($users as $user) {
            Mail::to($this->userCreated->email)->send(new OthersUserCreatedEmail($this->userCreated,$this->password,$user));
        }

        
    }
}
