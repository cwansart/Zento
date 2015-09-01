@extends('main')

@section('title', 'Termine')

@section('content')
    <div class="container">
        <div id='calendar'></div>

        <a class="btn btn-primary" id="show-create-dialog-button">Termin erstellen</a>
    </div>

    <div class="modal fade" id="appointment-create-dialog" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Termin erstellen</h4>
                </div>
                <div class="modal-body">
                    @include('appointments.createFormContainer')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                </div>
            </div>

        </div>
    </div>

    <div class="popover fade bottom" role="tooltip" id="appointment-tooltip">
        <div class="arrow"></div>
        <div class="popover-content">
            <div class="title"></div>
            <div class="text-info">
                <span class="start"></span>
                –
                <span class="end"></span>
            </div>
            <div class="description"></div>
            <div class="trainer hidden">Trainer: <span class="actual-trainer"></span></div>
        </div>
        <div class="popover-controls">
            <div style="margin: 0; padding: 0; line-height: 22px;">
                <a href="#" class="edit" title="Termin bearbeiten" data-toggle="tooltip" data-placement="right"></a>
                <a href="#" class="delete delete-confirm" title="Termin löschen" data-toggle="tooltip" data-placement="right"></a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#calendar').fullCalendar({
                lang: 'de',
                timeFormat: 'HH:MM',
                events: '{!! action('AppointmentController@index') !!}',

                dayClick: function (date, jsEvent, view) {
                    $('#start-picker').data().DateTimePicker.setDate(date);
                    $('#end-picker').data().DateTimePicker.setDate(date);
                    $('#appointment-create-dialog').modal('show');
                },

                eventClick: function (event, jsEvent, view) {
                    var that = this;
                    that.appointmentRoute = '{!! action('AppointmentController@show', null) !!}/' + event.id;

                    // these two lines enable the "fade out" effect
                    $('#appointment-tooltip').removeClass('in');
                    window.setTimeout(function() {
                        $.getJSON(that.appointmentRoute  ,function(appointment) {
                            var editRoute = ('{!! action('AppointmentController@edit') !!}').replace('%7Bappointments%7D', event.id);
                            var destroyRoute = ('{!! action('AppointmentController@destroy') !!}').replace('%7Bappointments%7D', event.id);
                            $('#appointment-tooltip .popover-controls .edit').attr('href', editRoute);
                            $('#appointment-tooltip .popover-controls .delete').attr('href', destroyRoute);

                            $('#appointment-tooltip .title').text(event.title);
                            $('#appointment-tooltip .description').text(event.description);

                            var format = event.allDay ? 'dd.mm.yyyy' : 'dd.mm.yyyy hh:MM';
                            var start = (new Date(event.start)).format(format);
                            var end = (new Date(event.end)).format(format);
                            $('#appointment-tooltip .start').text(start);
                            $('#appointment-tooltip .end').text(end);

                            if(event.user_id) {
                                var trainerRoute = '{!! action('UserController@show', null) !!}/' + event.user_id;
                                $.getJSON(trainerRoute, function(trainer) {
                                    $('#appointment-tooltip .actual-trainer').text(trainer.firstname + ' ' + trainer.lastname);
                                    $('#appointment-tooltip .trainer').removeClass('hidden');
                                });
                            } else {
                                $('#appointment-tooltip .trainer').addClass('hidden');
                            }

                            var tooltipCenter = $('#appointment-tooltip').width() / 2;
                            $('#appointment-tooltip').addClass('in').css('top', jsEvent.pageY).css('left', jsEvent.pageX - tooltipCenter);
                        });
                    }, 50);

                },
            });
            $('#calendar').fullCalendar('rerenderEvents');

            $('#show-create-dialog-button').on('click', function() {
                $('.form-horizontal')[0].reset();
                $('#appointment-create-dialog').modal('show');
            });

            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>

@endsection