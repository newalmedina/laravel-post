<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = "user_profiles";

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
  

    public function scopeUsers($query)
    {
        return $query->join('users', 'users.id', '=', 'user_profiles.user_id');
    }

    public function getFullNameAttribute()
    {
        return trim(ucfirst($this->attributes['first_name']) . " " . ucfirst($this->attributes['last_name']));
    }

    public function getBirthdayFormattedAttribute()
    {
        if (!empty($this->birthday)) {
            return (Carbon::createFromFormat('Y-m-d', $this->birthday))->format('d/m/Y');
        }

        return '';
    }
    public function getyearsAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d', $this->birthday);
        // Calcula la edad en años
        return $date->age;
    }
}
