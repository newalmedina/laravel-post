<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use Livewire\WithPagination;
use stdClass;

class TablaVisitas extends Component
{
    protected $listeners = [
        'facturarCita' => 'facturarCita',
        'finalizarCita' => 'finalizarCita'
    ];
    public $actualDate;

    public $estado;
    public $spanishMonths;
    public $filtros = [];
    public $with = [
        "patient.userProfile",
        "doctor.userProfile",
        "service",
        "createdBy"
    ];

    public function mount()
    {
        $this->getConsulta();
        $this->actualDate = Carbon::now()->format("d/m/Y");
    }


    public function facturarCita($id)
    {
        $appointment = Appointment::find($id);
        $appointment->paid_at = Carbon::now();
        $appointment->paid_by = Auth::user()->id;
        $appointment->color = "#ffc107";
        $appointment->save();
    }

    public function finalizarCita($id)
    {
        $appointment = Appointment::find($id);
        $appointment->finish_at = Carbon::now();
        $appointment->finish_by = Auth::user()->id;
        $appointment->color = "#28a745";
        $appointment->save();
    }

    public function getPatientInfo($id)
    {
        $appointment = Appointment::find($id);
        $objeto = new stdClass();

        // Asignar propiedades al objeto
        $objeto->nombre = $appointment->patient->userProfile->fullName;
        $objeto->edad = $appointment->patient->userProfile->years;
        $objeto->phone = $appointment->patient->userProfile->phone . "/" . $appointment->patient->userProfile->mobile;
        $objeto->email = $appointment->patient->email;
        $objeto->seguro = !empty($appointment->insurance) ? $appointment->insurance->name : "";
        $objeto->poliza = "";
 
        $objeto->photo = !empty( $appointment->patient->userProfile->photo)?url('admin/profile/getphoto/'.$appointment->patient->userProfile->photo):null;

        
        if (!empty($appointment->insurance)) {
            $patientSeguro = DB::table("patient_insurance_carriers")
                ->where("patient_insurance_carriers.insurance_carrier_id",  $appointment->insurance->id)
                ->where("patient_insurance_carriers.user_id",  $appointment->user_id)
                ->first();
            $objeto->poliza = !empty($patientSeguro->poliza) ? $patientSeguro->poliza : null;
        }



        $this->emit('obtenerInformacionPaciente', $objeto);
    }

    public function getConsulta()
    {
        $datos = Appointment::with($this->with)
            ->canshowDashboard()
            ->when(data_get($this->filtros, 'paciente'), fn ($q, $keyword) => $q->whereHas('patient.userProfile', fn ($q) => $q->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $keyword . '%')))
            ->when(data_get($this->filtros, 'doctor'), fn ($q, $keyword) => $q->whereHas('doctor.userProfile', fn ($q) => $q->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $keyword . '%')))
            ->when(data_get($this->filtros, 'created_by'), fn ($q, $keyword) => $q->whereHas('createdBy.userProfile', fn ($q) => $q->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $keyword . '%')))
            ->when(data_get($this->filtros, 'service'), fn ($q, $info) => $q->whereHas('service', fn ($q) => $q->where('name', 'like', '%' . $info . '%')))
            ->when(data_get($this->filtros, 'precio_min'), fn ($q, $info) => $q->where('total', '>=', $info))
            ->when(data_get($this->filtros, 'precio_max'), fn ($q, $info) => $q->where('total', '<=', $info))
            // ->when(data_get($this->filtros, 'paciente'), fn ($q, $info) => $q->whereHas('patient.userProfile', fn ($q) => $q->where('first_name', $info)))
            ->selectedCenter()
            ->where("appointments.start_at", ">=", Carbon::now()->startOfDay()->format("Y-m-d H:i:s"))
            ->where("appointments.start_at", "<=", Carbon::now()->endOfDay()->format("Y-m-d H:i:s"));

        if (!empty($this->estado)) {
            switch ($this->estado) {
                case "pend":
                    $datos
                        ->whereNull("appointments.finish_at")
                        ->whereNull("appointments.paid_at");
                    break;
                case "fact":
                    $datos
                        ->whereNull("appointments.finish_at")
                        ->whereNotNull("appointments.paid_at");
                    break;
                case "fin":
                    $datos
                        ->whereNotNull("appointments.finish_at");
                    # code...
                    break;

                default:
                    # codsadsadsadsasadsade...
                    break;
            }
        }

        return $datos->orderBy("start_at", "asc");
    }


    public function render()
    {
        return view(
            'livewire.dashboard.tabla-visitas',
            [
                'appointments' => $this->getConsulta()->paginate(10)
            ]
        );
    }
}
