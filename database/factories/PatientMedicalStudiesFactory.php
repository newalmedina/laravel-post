<?php

namespace Database\Factories;

use App\Models\Center;
use App\Models\DoctorProfile;
use App\Models\PatientMedicalStudies;
use App\Models\PatientProfile;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class PatientMedicalStudiesFactory extends Factory
{
    protected $model = PatientMedicalStudies::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {



        $user = User::select("users.*")->inRandomOrder()->patients()->first();

        $center = Center::inRandomOrder()->first();
        $year = date('Y');

        // Generamos una fecha aleatoria dentro del año actual
        $fecha = $this->faker->dateTimeBetween($year . '-01-01', $year . '-12-31')->format('Y-m-d');

        return [
            "user_id" => $user->id,
            "center_id" => $center->id,
            "description" => $this->faker->paragraph(),
            "date" => $fecha,
            "created_by" => 1,
        ];
        // Otros campos de la tabla user_profiles

    }
}
