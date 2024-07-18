<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Visitas extends Component
{
    public $appointmentToday = 0;
    public $appointmentTodayPending = 0;
    public $appointmentThisWeek = 0;
    public $appointmentThisMonth = 0;

    public $visitaMesFilter = null;

    protected $listeners = ['actualizarFechaVisita'];

    public function mount()
    {
        $this->visitaMesFilter = Carbon::now()->format("m/Y");
        $this->getDatos();
    }

    public function actualizarFechaVisita($campo, $fecha)
    {
        $this->{$campo} = $fecha;
        $this->getDatos();
    }

    private function getDatos()
    {
        // Inicializar la variable $visitCount
        $this->appointmentToday = Appointment::where("center_id", auth()->user()->hasSelectedCenter())
            ->where("start_at", ">=", Carbon::now()->startOfDay()->format("Y-m-d H:i:s"))
            ->where("end_at", "<=", Carbon::now()->endOfDay()->format("Y-m-d H:i:s"))
            ->count();
        $this->appointmentTodayPending = Appointment::where("center_id", auth()->user()->hasSelectedCenter())
            ->where("start_at", ">=", Carbon::now()->startOfDay()->format("Y-m-d H:i:s"))
            ->where("end_at", "<=", Carbon::now()->endOfDay()->format("Y-m-d H:i:s"))
            ->whereNull("finish_at")
            ->count();
        $this->appointmentThisWeek = Appointment::where("center_id", auth()->user()->hasSelectedCenter())
            ->where("start_at", ">=", Carbon::now()->startOfWeek()->format("Y-m-d H:i:s"))
            ->where("end_at", "<=", Carbon::now()->endOfWeek()->format("Y-m-d H:i:s"))
            ->count();
        $visitaQuery = Appointment::where("center_id", auth()->user()->hasSelectedCenter());


        if (!empty($this->visitaMesFilter)) {
            $visitaQuery->where("start_at", ">=", Carbon::createFromFormat("m/Y", $this->visitaMesFilter)->startOfMonth()->format("Y-m-d H:i:s"))
                ->where("end_at", "<=", Carbon::createFromFormat("m/Y", $this->visitaMesFilter)->endOfMonth()->format("Y-m-d H:i:s"));
        }
        $this->appointmentThisMonth =  $visitaQuery->count();
    }

    public function render()
    {
        return view('livewire.dashboard.visitas');
    }
}
