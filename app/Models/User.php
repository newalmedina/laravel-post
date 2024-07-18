<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use App\Notifications\MyResetPassword;
use App\Notifications\MyVerifyEmail;
use App\Services\SettingsServices;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Settings;

class User extends Authenticatable implements MustVerifyEmail
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function sendPasswordResetNotification($token)
    {
        $allowEmail = SettingsServices::allowEmails();


        if ($allowEmail) {
            //cambiar config del .env
            $setConfiguration = SettingsServices::setSmtpConfiguration();

            $this->notify(new MyResetPassword($token));
        }
    }

    public function sendEmailVerificationNotification()
    {
        $allowEmail = SettingsServices::allowEmails();


        if ($allowEmail) {
            //cambiar config del .env
            $setConfiguration = SettingsServices::setSmtpConfiguration();

            $this->notify(new MyVerifyEmail($this));
        }
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function doctorProfile()
    {
        return $this->hasOne('App\Models\DoctorProfile', 'user_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patientProfile()
    {
        return $this->hasOne('App\Models\PatientProfile', 'user_id');
    }

    public function hasSelectedCenter()
    {
        if (!empty($this->userProfile)) {
            return $this->userProfile->selected_center;
        }
        return null;
    }

    public function medicines()
    {
        return $this->hasMany(PatientMedicine::class,  'user_id', 'id')->withTimestamps();
    }



    public function insuranceCarriers()
    {
        return $this->belongsToMany(InsuranceCarrier::class, 'patient_insurance_carriers', 'user_id', 'insurance_carrier_id')->withPivot(['poliza'])->withTimestamps();
    }

    public function specializations()
    {
        return $this->belongsToMany(MedicalSpecialization::class, 'doctor_specializations', 'user_id', 'specialization_id')->withTimestamps();
    }

    public function getCreatedAtFormattedAttribute()
    {
        try {
            if (!empty($this->created_at)) {
                return $this->created_at->format('d/m/Y');
            }
        } catch (\Exception $ex) {
        }

        return "";
    }

    public function scopePatients($query)
    {

        return $query->join("role_user", "users.id", "=", "role_user.user_id")
            ->join("roles", "role_user.role_id", "=", "roles.id")
            ->whereIn("roles.name", ["patient"]);
    }
    public function scopeClinicPersonal($query)
    {

        return $query->leftJoin("role_user", "users.id", "=", "role_user.user_id")
            ->leftJoin("roles", "role_user.role_id", "=", "roles.id")
            ->whereIn("roles.name", ["doctor"]);
    }
    public function scopeNotPatients($query)
    {

        return $query->leftJoin("role_user", "users.id", "=", "role_user.user_id")
            ->leftJoin("roles", "role_user.role_id", "=", "roles.id")
            ->whereNotIn("roles.name", ["patient"])
            ->orWhereNull('roles.name');
    }

    public function isDoctor()
    {

        $roles = $this->roles->where('name', "doctor");
        return  count($roles);
    }


    
    public function getSpecializationStringAttribute()
    {
        $data = [];
        foreach ($this->specializations as $specialization) {
            $data[] = $specialization->name;
        }
        return implode(", ", $data);
    }

    public function scopeActive($query)
    {
        return $query->where('users.active', 1);
    }
    public function scopeAllowRecieveEmails($query)
    {
        return $query->where('users.permit_recieve_emails', 1);
    }
}
