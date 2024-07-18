<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Ganancias extends Component
{
    protected $listeners = ['getDataGanancias'];
    public $yearList;
    public $actualYear;
    public $yearsSelected = 4;
    public $color = [
        "blue",
        "red",
        "orange",
        "yellow",
    ];
    public $appointmentsData = [];
    public $spanishMonths;

    public function mount()
    {
        $this->actualYear = Carbon::now()->year;
        $this->yearList = Appointment::select(DB::raw('YEAR(start_at) as year'))
            ->pluck('year')
            ->unique()
            ->take($this->yearsSelected)
            ->sort();

        $this->spanishMonths  = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        $this->getDataGanancias();
    }


    public function getDataGanancias()
    {
        $cont = 0;
        foreach ($this->yearList as  $year) {

            $appointments = Appointment::whereNotNull('paid_at')
                ->whereYear('start_at', $year)
                ->select(
                    DB::raw('MONTH(start_at) as month'),
                    DB::raw('SUM(total) as total')
                )
                ->groupBy(DB::raw('MONTH(start_at)'))
                ->orderBy(DB::raw('MONTH(start_at)'))
                ->where("appointments.center_id", auth()->user()->userProfile->center->id)
                ->get();



            $this->appointmentsData[$year]['color'] = $this->color[$cont];
            foreach ($this->spanishMonths as $value) {
                # code...
                $this->appointmentsData[$year]['data'][$value] = 0;
            }

            foreach ($appointments as $appointment) {
                $monthIndex = $appointment->month - 1; // Los meses inician en 1 pero el arreglo en 0
                // $this->appointmentsData[$year]['labels'][] = $this->spanishMonths[$monthIndex]; // Nombres de los meses en español
                $this->appointmentsData[$year]['data'][$this->spanishMonths[$monthIndex]] = $appointment->total; // Suma total de Appointments por mes
            }
            $cont++;
        }

        // dd($this->appointmentsData);

        // dd($this->appointmentsData);
    }
    public function generateRandomColor()
    {
        // Generar un color hexadecimal aleatorio
        $color = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);

        return response()->json(['color' => $color]);
    }

    public function render()
    {
        return view('livewire.dashboard.ganancias');
    }
}
