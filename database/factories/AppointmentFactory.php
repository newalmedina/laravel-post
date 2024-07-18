<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Center;
use App\Models\DoctorProfile;
use App\Models\PatientMedicalStudies;
use App\Models\PatientMonitoring;
use App\Models\PatientProfile;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {



        $user = User::select("users.*")->inRandomOrder()->patients()->active()->first();


        $center = Center::inRandomOrder()->first();
        $service = Service::inRandomOrder()->first();
        // Obtener el año actual
        $currentYear = Carbon::now()->year;

        // Generar un año aleatorio entre el año actual y dos años atrás
        $randomYear = $this->faker->numberBetween($currentYear - 2, $currentYear);

        // Generar una fecha dentro del año aleatorio
        $randomDate = $this->faker->dateTimeBetween("$randomYear-01-01", "$currentYear-12-31")->format('Y-m-d H:i:s');
        $color = "#6c757d";
        $finish_at = null;

        $paid_at = $this->faker->numberBetween(0, 1) == 1 ? Carbon::now() : null;

        if (!empty($paid_at)) {
            $color = "#ffc107";
            $finish_at = $this->faker->numberBetween(0, 1) == 1 ? Carbon::now() : null;
            if (!empty($finish_at)) {
                $color = "#28a745";
            }
        }
        return [
            "title" => "Cita medica",
            "user_id" => $user->id,
            "center_id" => $center->id,
            "created_by" => 1,
            "doctor_id" => 1,
            "service_id" => $service->id,
            "start_at" => $randomDate,
            "end_at" => $randomDate,
            "price" => $service->price,
            "total" => $service->price,
            "color" => $color,
            "comment" => $this->faker->paragraph(),
            "paid_at" => $paid_at,
            "finish_at" => $finish_at,
        ];
        // Otros campos de la tabla user_profiles

    }
}
