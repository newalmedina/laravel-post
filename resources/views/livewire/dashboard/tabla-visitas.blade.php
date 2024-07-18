@if(

Auth::user()->isAbleTo("admin-dashboard-appointment-programadas-today-all") ||
Auth::user()->isAbleTo("admin-dashboard-appointment-programadas-today-doctor") ||
Auth::user()->isAbleTo('admin-dashboard-appointment-programadas-today-created-by-user')
)

@if (Auth::user()->hasSelectedCenter() )

<div class="col-12 ">
    <section class="card card-featured-top card-featured-primary">
        <header class="card-header">
            <div class="card-actions">
                <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
            </div>

            <span>
                <h2 class="card-title">Visitas Programadas Hoy <small>{{ $actualDate }}</small>
                    <span class="ms-2 badge bg-secondary badge-circle">{{ $appointments->count() }}</span>
                </h2>

            </span>
        </header>

        <div class="card-body">

            <select name="" id="" wire:model.debounce.750ms="estado">
                <option value="">Todos los Estados</option>
                <option value="pend">Pendiente</option>
                <option value="fact">facturado</option>
                <option value="fin">Finalizado</option>
            </select>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Doctor</th>
                            <th>Creado por</th>
                            <th>Servicio</th>
                            <th>Precio</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Acción</th>


                        </tr>
                        <tr>
                            <td><input wire:model.debounce.750ms="filtros.paciente" type="text" class="form-control form-control-sm"></td>
                            <td><input wire:model.debounce.750ms="filtros.doctor" type="text" class="form-control form-control-sm"></td>
                            <td><input wire:model.debounce.750ms="filtros.created_by" type="text" class="form-control form-control-sm"></td>
                            <td><input wire:model.debounce.750ms="filtros.service" type="text" class="form-control form-control-sm"></td>
                            <td width="100">
                                <input wire:model.debounce.750ms="filtros.precio_min" type="number" class="form-control form-control-sm">
                                <input wire:model.debounce.750ms="filtros.precio_max" type="number" class="form-control form-control-sm">
                            </td>
                            <td>

                            </td>
                            <td></td>
                            <td></td>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                        <tr>
                            <td> {{ $appointment->patient->userProfile->fullName }} {{ $appointment->id }}</td>
                            <td>{{ $appointment->doctor->userProfile->fullName }}</td>
                            <td>{{ $appointment->createdBy->userProfile->fullName }}</td>
                            <td>{{ $appointment->service->name }}</td>
                            <td>{{ $appointment->total }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->start_at )->format("H:i")}}</td>
                            <td>
                                @php
                                //estado pendiente
                                $state=0;
                                $labelState="Pendiente";
                                $colorState="badge-default";



                                if(!empty($appointment->paid_at)){
                                $state=1;
                                $labelState="Facturado";
                                $colorState="badge-warning";
                                }
                                if(!empty($appointment->finish_at)){
                                $state=2;
                                $labelState="Finalizado";
                                $colorState="badge-success";
                                }
                                @endphp
                                <span class="badge {{ $colorState }}">{{ $labelState }}</span>
                            </td>
                            <td>

                                @if ($appointment->canInfoBasicaDashboard())
                                <button wire:click="getPatientInfo({{ $appointment->id }})" class="btn btn-primary btn-xs">
                                    <i class="fas fa-sticky-note"></i>
                                </button>
                                @endif
                                @if(Auth::user()->isAbleTo('admin-patients-update'))
                                <a href="{{ route('admin.patients.edit', $appointment->user_id) }}" class="btn btn-info btn-xs" target="_blank">
                                    <i class="fas fa-user-injured" aria-hidden="true"></i>
                                </a>
                                @elseif(Auth::user()->isAbleTo('admin-patients-read'))
                                <a href="{{ route('admin.patients.show', $appointment->user_id) }}" class="btn btn-info btn-xs" target="_blank">
                                    <i class="fas fa-user-injured" aria-hidden="true"></i>
                                </a>
                                @endif

                                @if ($appointment->canFacturarDashboard())
                                <button onclick="facturar({{ $appointment->id }})" class="btn btn-default btn-xs">
                                    <i class="fas fa-dollar-sign"></i>
                                </button>
                                @endif
                                @if ($appointment->canFinalizarDashboard())
                                <button onclick="finalizar({{ $appointment->id }})" class="btn btn-primary btn-xs">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                                {{-- @switch( $state)
                                            @case(1)
                                                @if(Auth::user()->isAbleTo('admin-dashboard-appointment-programadas-today-end-all'))
                                                    <button onclick="finalizar({{ $appointment->id }})" class="btn btn-primary btn-xs">
                                <i class="fas fa-check"></i>
                                </button>
                                @elseif(Auth::user()->isAbleTo('admin-dashboard-appointment-programadas-today-end') && $appointment->soySuDoctor() )
                                <button onclick="finalizar({{ $appointment->id }})" class="btn btn-primary btn-xs">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif

                                @break
                                @case(2)
                                @break
                                @default

                                @if(Auth::user()->isAbleTo('admin-dashboard-appointment-programadas-today-facturar-all'))
                                <button onclick="facturar({{ $appointment->id }})" class="btn btn-default btn-xs">
                                    <i class="fas fa-dollar-sign"></i>
                                </button>
                                @elseif(Auth::user()->isAbleTo('admin-dashboard-appointment-programadas-today-facturar') && $appointment->soySuDoctor() )
                                <button onclick="facturar({{ $appointment->id }})" class="btn btn-default btn-xs">
                                    <i class="fas fa-dollar-sign"></i>
                                </button>
                                @endif

                                @endswitch --}}
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">

                <small>
                    {{ $appointments->links() }}
                </small>
            </div>
        </div>
    </section>
</div>
@endif


@endif
@push('scripts')
<script>
    function facturar(id) {
        Swal.fire({
            title: '¿Seguro que quieres facturar esta cita?'
            , text: 'Esta acción no se puede deshacer'
            , icon: 'question'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Sí, estoy seguro'
            , cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('facturarCita', id);
            }
        });
    }

    function finalizar(id) {
        Swal.fire({
            title: '¿Seguro que quieres finalizar esta cita?'
            , text: 'Esta acción no se puede deshacer'
            , icon: 'question'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Sí, estoy seguro'
            , cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('finalizarCita', id);
            }
        });
    }

    Livewire.on('obtenerInformacionPaciente', function(datos) {
        var htmlText = "";
        if (datos.photo) {
            htmlText += `
             <img width='300' src=' ${datos.photo}' 
             id='image_ouptup' class="rounded-circle" alt="{{ Auth::user()->userProfile->fullName }}">
             <p></p>`;
        }
        htmlText += `
                    <p><strong>Nombre:</strong> ${datos.nombre}</p>
                    <p><strong>Edad:</strong> ${datos.edad}</p>
                    <p><strong>Telefono:</strong> ${datos.phone}</p>
                    <p><strong>Email:</strong> ${datos.email}</p>
                    
                    <!-- Agrega más detalles del paciente según sea necesario -->
                `;
        if (datos.seguro) {
            htmlText += `
           <p><strong>Seguro:</strong> ${datos.seguro}</p>
                    <p><strong>Poliza:</strong> ${datos.poliza}</p>`;
        }else{
              htmlText += `
           <h3 class='text-warning'><strong>Consulta sin segro`;
        }
        Swal.fire({
            title: 'Información del Paciente'
            , html: htmlText
            , confirmButtonText: 'Cerrar'
        });


    });

</script>
@endpush
