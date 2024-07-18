@if(
Auth::user()->isAbleTo("admin-dashboard-center-profits") 
)
    @if (Auth::user()->hasSelectedCenter() )
            <div class="col-12 ">
                <section class="card card-featured-top card-featured-primary card-collapsed">
                    <header class="card-header">
                        <div class="card-actions">
                            <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                            <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                        </div>
        
                        <h2 class="card-title">Resumen Ganancias</h2>
                    </header>          
        
                    <div class="card-body">  
                       
                        @if(count($appointmentsData)>0)
                            <canvas id="lineChart"  height="100"></canvas>                        
                        @endif
                    </div>
                </section>
            </div>
    @endif


@endif
@push('scripts')
<script src="{{ asset('assets/admin/vendor/chartjs/chartjs.min.js')}}"></script>
                 
    <script>
        const formatter = new Intl.NumberFormat('es-ES', {
            style: 'currency',
            currency: 'DOP', // Cambia a tu moneda deseada
            minimumFractionDigits: 2,
        });

        @if(count($appointmentsData)>0)
        var ctx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($spanishMonths) !!},
                
                datasets: [
                    @php
                        $cont=0;
                    @endphp
                    @foreach ($appointmentsData as $key=>$value)
                        @if ($cont>0)
                            ,    
                        @endif
                        {
                            label: '{{ $key }}',
                            data: {!! json_encode($value['data']) !!},
                            borderColor: "{{ $value['color'] }}",
                            borderWidth: 3,
                            fill: false
                            @if ($key==$actualYear)
                            ,hidden:false
                            @else    
                            ,hidden:true
                            @endif
                        }   
                        @php
                            $cont++;
                        @endphp   
                    @endforeach
            ]
            },

            options: {
                animation: {
                    duration: 2000, // Duración de la animación en milisegundos
                    easing: 'easeInOutQuart' // Tipo de animación (opcional)
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return  formatter.format(value)+"$" ; // Agrega el símbolo de dólar al valor
                            }
                        }
                    }
                }
            }
        });
    @endif
  
    </script>

@endpush
