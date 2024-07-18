@section('head_page')
<link href="{{ asset('/assets/admin/vendor/fullcalendar.min.css')}}" rel="stylesheet" />
<style>
    #calendar-container {
        width: 100%;
    }

    #calendar {
        padding: 10px;
        margin: 10px;
        width: 1340px;
        height: 610px;
        border: 2px solid black;
    }
</style>
@stop

<div class="row">
    <div class="col">
        <section class="card card-featured-top card-featured-primary">
            <header class="card-header">
                <div class="card-actions">
                    <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                    <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                </div>

                <h2 class="card-title">{{ $title }}</h2>
            </header>

            <div class="card-body">
                <div class="row">
                    <div id='calendar-container' wire:ignore>
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@section('foot_page')
<!-- DataTables -->

{{-- <script>
    $(document).ready(function() {
        $('.select2').select2(); 
    });

</script> --}}

<script src="{{ asset('/assets/admin/vendor/fullcalendar.min.js') }}"></script>
<script src="{{ asset('/assets/admin/vendor/locales-all.min.js') }}"></script>
<script>
    document.addEventListener('livewire:load', function() {
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;
        var calendarEl = document.getElementById('calendar');
        var checkbox = document.getElementById('drop-remove');
        var data = @this.events;

        var calendar = new Calendar(calendarEl, {
            events: JSON.parse(data),
            dateClick(info) {
                var title = prompt('Enter Event Title');
                var date = new Date(info.dateStr + 'T00:00:00');
                if (title != null && title != '') {
                    calendar.addEvent({
                        title: title,
                        start: date,
                        allDay: true
                    });
                    var eventAdd = {
                        title: title,
                        start: date
                    };
                    @this.addevent(eventAdd);
                    alert('Great. Now, update your database...');
                } else {
                    alert('Event Title Is Required');
                }
            },
            editable: true,
            selectable: true,
            displayEventTime: false,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function(info) {
                // is the "remove after drop" checkbox checked?
                if (checkbox.checked) {
                    // if so, remove the element from the "Draggable Events" list
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                }
            },
            eventDrop: info => @this.eventDrop(info.event, info.oldEvent),
            loading: function(isLoading) {
                if (!isLoading) {
                    // Reset custom events
                    this.getEvents().forEach(function(e) {
                        if (e.source === null) {
                            e.remove();
                        }
                    });
                }
            }
        });
        calendar.render();
        @this.on(`refreshCalendar`, () => {
            calendar.refetchEvents()
        });
    });
</script>

@stop