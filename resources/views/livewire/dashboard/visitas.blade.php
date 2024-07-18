@if(
Auth::user()->isAbleTo("admin-dashboard-appointment-today") ||
Auth::user()->isAbleTo("admin-dashboard-appointment-pending-today") ||
Auth::user()->isAbleTo("admin-dashboard-appointment-this-week")  ||
Auth::user()->isAbleTo("admin-dashboard-appointment-this-month") 
)
    @if (Auth::user()->hasSelectedCenter() )
        <div class="row">
            <div class="col-12">
                <div class="row mb-3">
                    @if(Auth::user()->isAbleTo("admin-dashboard-appointment-today") )
                        <div class="col-12 col-sm-4 col-md-3">
                            <section class="card card-featured-left card-featured-primary mb-3">
                                <div class="card-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-primary">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>

                                        </div>

                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Visitas Hoy</h4>
                                                <div class="info">
                                                    <strong class="amount">{{ $appointmentToday }}</strong><br>
                                                    <span class='text-primary'>(Total)</span>
                                                </div>
                                            </div>
                                            {{-- <div class="summary-footer">
                                                <a class="text-muted text-uppercase" href="#">(view all)</a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endif
                    @if(Auth::user()->isAbleTo("admin-dashboard-appointment-pending-today") )
                        <div class="col-12 col-sm-4 col-md-3">
                            <section class="card card-featured-left card-featured-secondary">
                                <div class="card-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-secondary">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Visitas Hoy </h4>
                                                <div class="info">
                                                    <strong class="amount">{{ $appointmentTodayPending }}</strong><br>
                                                    <span class='text-primary'>(Pendientes)</span>
                                                </div>
                                            </div>
                                            {{-- <div class="summary-footer">
                                                <a class="text-muted text-uppercase" href="#">(withdraw)</a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endif
                    @if(Auth::user()->isAbleTo("admin-dashboard-appointment-this-week") )
                        <div class="col-12 col-sm-4 col-md-3">
                            <section class="card card-featured-left card-featured-tertiary mb-3">
                                <div class="card-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-tertiary">
                                                <i class="far fa-calendar-check"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Visitas Semana Actual</h4>
                                                <div class="info">
                                                    <strong class="amount">{{ $appointmentThisWeek }}</strong>
                                                </div>
                                            </div>
                                            {{-- <div class="summary-footer">
                                                <a class="text-muted text-uppercase" href="#">(statement)</a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endif
                    @if(Auth::user()->isAbleTo("admin-dashboard-appointment-this-month") )
                        <div class="col-12 col-sm-4 col-md-3">
                            <section class="card card-featured-left card-featured-quaternary">
                                <div class="card-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-quaternary">
                                                <i class="far fa-calendar-check"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Visitas Mensual</h4>
                                                <div class="info">
                                                    <strong class="amount">{{ $appointmentThisMonth }}</strong>
                                                </div>
                                            </div>
                                            <div class="summary-footer text-start">
                                                <labe>Seleccione mes</label>
                                                <input   type="text"  autocomplete="off" class="form-control datepicker visitaMesFilter" wire:model="visitaMesFilter"  wire:change='getDatos' >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endif
                </div>
            </div>
        </div>    
    @endif

@endif
@push('scripts')
<script>
    $(document).ready(function() {
    
        $('.visitaMesFilter').datepicker(
            {
                language: 'es',
                format: 'mm/yyyy',
                orientation:'bottom',
                autoclose: true,
                viewMode: "months", 
                minViewMode: "months",
                
            }
        );    

        $('.visitaMesFilter').datepicker().on('changeDate', function(e) {
            // Obtiene la fecha seleccionada del evento
            // Emite el evento a Livewire con la fecha seleccionada
            Livewire.emit('actualizarFechaVisita',"visitaMesFilter", e.format());
        });

           
    });
</script>
@endpush
