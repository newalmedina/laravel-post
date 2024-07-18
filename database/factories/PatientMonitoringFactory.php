<?php

namespace Database\Factories;

use App\Models\Center;
use App\Models\DoctorProfile;
use App\Models\PatientMedicalStudies;
use App\Models\PatientMonitoring;
use App\Models\PatientProfile;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class PatientMonitoringFactory extends Factory
{
    protected $model = PatientMonitoring::class;
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
            "date" => $fecha,
            "created_by" => 1,
            "height" => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
            "weight" => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
            "temperature" => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
            "heart_rate" => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
            "blood_presure" => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
            "rheumatoid_factor" => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
            "motive" => $this->faker->paragraph(),
            "physical_exploration" => $this->faker->paragraph(),
            "symptoms" => $this->faker->paragraph(),
            "diagnoses" => $this->faker->paragraph(),
            "comment" => $this->faker->paragraph(),
        ];
        // Otros campos de la tabla user_profiles

    }
}
