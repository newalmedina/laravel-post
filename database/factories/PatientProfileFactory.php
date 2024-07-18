<?php

namespace Database\Factories;

use App\Models\Center;
use App\Models\DoctorProfile;
use App\Models\PatientProfile;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class PatientProfileFactory extends Factory
{
    protected $model = PatientProfile::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {


        $user = new User();



        $user->email = $this->faker->unique()->safeEmail();
        $user->active = $this->faker->numberBetween(0, 1);
        $user->email_verified_at = Carbon::now();

        $user->password =  bcrypt("Secret");
        $user->save();

        $fechaInicio = '-50 years'; // Hace 30 años hacia atrás
        $fechaFin = '-1 years'; // Hace 18 años hacia atrás

        $cumpleanios = $this->faker->dateTimeBetween($fechaInicio, $fechaFin)->format('Y-m-d');
        $userProfile = new UserProfile();

        $userProfile->user_id = $user->id;
        $userProfile->first_name = $this->faker->name();
        $userProfile->last_name = $this->faker->lastName();
        $userProfile->birthday = $cumpleanios;
        $userProfile->identification = $this->faker->unique()->numberBetween(10000000, 99999999);
        $userProfile->phone = $this->faker->phoneNumber;
        $userProfile->mobile = $this->faker->phoneNumber;
        $userProfile->gender = $this->faker->randomElement(['male', 'female']);
        $userProfile->created_center = 1;
        $userProfile->save();


        $role = Role::where("name", "patient")->first();

        if (!empty($role->id)) {
            $user->syncRoles([$role->id]);
        }


        return [
            "user_id" => $user->id,
            "allergies" => $this->faker->sentence(),
            "pathological_diseases" => $this->faker->sentence(),
            "surgical_diseases" => $this->faker->sentence(),
            "family_history" => $this->faker->sentence(),
            "gynecological_history" => $this->faker->sentence(),
            "others" => $this->faker->sentence(),
            "created_by" => 1,
        ];
        // Otros campos de la tabla user_profiles

    }
}
