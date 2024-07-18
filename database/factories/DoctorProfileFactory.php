<?php

namespace Database\Factories;

use App\Models\Center;
use App\Models\DoctorProfile;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class DoctorProfileFactory extends Factory
{
    protected $model = DoctorProfile::class;
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

        $user->password =  bcrypt("Secret15");
        $user->save();

        $fechaInicio = '-50 years'; // Hace 30 años hacia atrás
        $fechaFin = '-18 years'; // Hace 18 años hacia atrás

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


        $role = Role::where("name", "doctor")->first();

        if (!empty($role->id)) {
            $user->syncRoles([$role->id]);
        }


        //asignar centro

        $center = Center::inRandomOrder()->first();

        if (!empty($center->id)) {
            $user = User::find($user->id);

            $user->userProfile->selected_center = $center->id;
            $user->userProfile->save();
            $user->centers()->sync([$center->id]);
        }


        return [
            "user_id" => $user->id
        ];
        // Otros campos de la tabla user_profiles

    }
}
