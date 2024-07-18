@if(
Auth::user()->isAbleTo("admin-dashboard-doctor-number-this-center")||
Auth::user()->isAbleTo("admin-dashboard-apatient-number-this-center")||
Auth::user()->isAbleTo("admin-dashboard-patient-medicines-number") ||
Auth::user()->isAbleTo("admin-dashboard-patient-studies-number") 
)
    @if (Auth::user()->hasSelectedCenter() )
        <div class="row">
            <div class="col-12">
                <div class="row mb-3">
                    @if(Auth::user()->isAbleTo("admin-dashboard-doctor-number-this-center") )
                        <div class="col-12 col-sm-4 col-md-3">
                            <section class="card card-featured-left card-featured-primary mb-3">
                                <div class="card-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-primary">
                                                <i class="fas fa-user-md"></i>
                                            </div>

                                        </div>

                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Medicos</h4>
                                                <div class="info">
                                                    
                                                    <strong class="amount">{{ $doctors }}</strong><br>
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
                    @if(Auth::user()->isAbleTo("admin-dashboard-apatient-number-this-center") )
                        <div class="col-12 col-sm-4 col-md-3">
                            <section class="card card-featured-left card-featured-secondary">
                                <div class="card-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-secondary">
                                                <i class="fas fa-user-injured"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Pacientes Consultados</h4>
                                                <div class="info">
                                                    <strong class="amount">{{ $patients }}</strong><br>
                                                </div>
                                            </div>
                                            <div class="summary-footer text-start">
                                                <labe>Seleccione mes</label>
                                                <input   type="text"  autocomplete="off" class="form-control datepicker-doctor-patient" data-id="patientFilter" wire:model="patientFilter"  wire:change='getDatos' >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        @endif
                        @if(Auth::user()->isAbleTo("admin-dashboard-patient-medicines-number") )
                        <div class="col-12 col-sm-4 col-md-3">
                            <section class="card card-featured-left card-featured-tertiary mb-3">
                                <div class="card-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-tertiary">
                                                <i class="fa fa-pills"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Recetas Prescritas</h4>
                                                <div class="info">
                                                    <strong class="amount">{{ $recetas }}</strong>
                                                </div>
                                            </div>
                                            <div class="summary-footer text-start">
                                                <labe>Seleccione mes</label>
                                                <input   type="text"  autocomplete="off" class="form-control datepicker-doctor-patient" data-id="recetaFilter" wire:model="recetaFilter"  wire:change='getDatos' >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        @endif
                        @if(Auth::user()->isAbleTo("admin-dashboard-patient-studies-number") )
                        <div class="col-12 col-sm-4 col-md-3">
                            <section class="card card-featured-left card-featured-quaternary">
                                <div class="card-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-quaternary">
                                                <i class="fa fa-book-medical"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Estudios Prescritos</h4>
                                                <div class="info">
                                                    <strong class="amount">{{ $estudios }}</strong>
                                                </div>
                                            </div>
                                            <div class="summary-footer text-start">
                                                <labe>Seleccione mes</label>
                                                <input   type="text"  autocomplete="off" class="form-control datepicker-doctor-patient" data-id="estudiosFilter" wire:model="estudiosFilter"  wire:change='getDatos' >
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
    
        $('.datepicker-doctor-patient').datepicker(
            {
                language: 'es',
                format: 'mm/yyyy',
                orientation:'bottom',
                autoclose: true,
                viewMode: "months", 
                minViewMode: "months",
                
            }
        );    
        

        $('.datepicker-doctor-patient').datepicker().on('changeDate', function(e) {
            let inputName = $(this).data("id");
            // Obtiene la fecha seleccionada del evento
            // Emite el evento a Livewire con la fecha seleccionada
            Livewire.emit('actualizarFechaDoctorPatient',inputName, e.format());
        });

     
      
    });
</script>
@endpush