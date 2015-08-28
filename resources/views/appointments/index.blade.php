@extends('main')

@section('title', 'Termine')

@section('content')
    <div class="container">
        <div id='calendar'></div>

        <button id="buttonCreate" type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">Termin erstellen</button>

        <div class="modal fade" id="createModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h4 id='modal_title' class="modal-title">Termin erstellen</h4>
                    </div>

                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">

                                {!! Form::open(array('id' => 'appointment-create-dialog', 'class' => 'form-horizontal', 'method' => 'POST', 'route' => 'appointments.store')) !!}
                                @include('appointments._form')

                                <div class="form-group">
                                    <div class="col-md-6 col-md-6 col-md-offset-3">
                                        {!! Form::submit('Termin speichern', ['class' => 'btn btn-primary']) !!}
                                    </div>
                                </div>

                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="appointment-show-dialog" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id='appointment-show-title' class="modal-title">Termindetails</h4>
                    </div>

                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-3">Beschreibung</div>
                                <div class="col-md-6" id="appointment-show-description"></div>
                            </div>

                            {{-- This is for all day appointments --}}
                            <div class="row" id="appointment-show-date-wrapper">
                                <div class="col-md-3">Datum</div>
                                <div class="col-md-6" id="appointment-show-date"></div>
                            </div>

                            {{-- This is for appointments with an start and end date --}}
                            <div id="appointment-show-startend-wrapper">
                                <div class="row">
                                    <div class="col-md-3">Von</div>
                                    <div class="col-md-6" id="appointment-show-start"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Bis</div>
                                    <div class="col-md-6" id="appointment-show-end"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">Trainer</div>
                                <div class="col-md-6" id="appointment-show-trainer"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a id="appointment-show-edit-route" class="btn btn-primary">Bearbeiten</a>
                        <a id="appointment-show-destroy-route" class="btn btn-primary delete-confirm">Löschen</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        var _dateFormat = 'DD.MM.YYYY';
        var _timeFormat = 'HH:mm';

        $(document).ready(function() {

            $('#calendar').fullCalendar({
                timeFormat: _timeFormat,
                events: '{!! action('AppointmentController@index') !!}',

                dayClick: function (date, jsEvent, view) {
                    var start_date = date.format(_dateFormat+' '+_timeFormat);
                    var end_date = start_date;

                    // clear form
                    $('#createModal form')[0].reset();

                    // fill modal dialog with data
                    var storeRoute = '{!! action('AppointmentController@store') !!}';
                    $('#appointment-create-dialog').attr('action', storeRoute);

                    $('#appointment-create-dialog [name=date]').val(start_date);
                    $('#appointment-create-dialog [name=end_date]').val(end_date);

                    $('#createModal').modal('show');
                },

                eventClick: function (event, jsEvent, view) {

                    if(event.allDay) {
                        event.end = event.start;
                    }

                    var start_date = event.allDay ? event.start.format(_dateFormat) :event.start.format(_dateFormat+' '+_timeFormat);
                    var end_date = event.end.format(_dateFormat+' '+_timeFormat);

                    // fill modal dialog with data
                    var updateRoute = '{!! action('AppointmentController@update', null) !!}';
                    $('#appointment-edit-dialog').attr('action', updateRoute+'/'+event.id);

                    var destroyRoute = '{!! action('AppointmentController@destroy', null) !!}';
                    $('#appointment-show-destroy-route').attr('href', destroyRoute+'/'+event.id);

                    var editRoute = '{{ action('AppointmentController@edit', '!id!') }}';
                    _globroute = editRoute;
                    $('#appointment-show-edit-route').attr('href', editRoute.replace('!id!', event.id));

                    $('#appointment-show-title').text(event.title);

                    if(!event.description || 0 === event.description.length) {
                        $('#appointment-show-description').parent().hide();
                    } else {
                        $('#appointment-show-description').text(event.description);
                        $('#appointment-show-description').parent().show();
                    }

                    if(event.allDay) {
                        $('#appointment-show-date').text(start_date);
                        $('#appointment-show-date-wrapper').show();
                        $('#appointment-show-startend-wrapper').hide();
                    } else {
                        $('#appointment-show-start').text(start_date);
                        $('#appointment-show-end').text(end_date);
                        $('#appointment-show-startend-wrapper').show();
                        $('#appointment-show-date-wrapper').hide();
                    }

                    if(event.user_id) {
                        // Dynamically load the user data 'cause we don't have it all the time. May not work, that's
                        // why I set a default value.
                        $.getJSON('{!! action('UserController@show', null) !!}/'+event.user_id, function(trainer) {
                            if(trainer.firstname !== undefined && trainer.lastname !== undefined) {
                                $('#appointment-show-trainer').text(trainer.firstname+' '+trainer.lastname);
                            } else {
                                $('#appointment-show-trainer').text('Wurde gelöscht, bitte melden!');
                            }

                            // we need it here and in the else block as well, because this is a callback function that
                            // gets called when the user data was received.
                            $('#appointment-show-dialog').modal('show');
                        }).fail(function() {
                            alert('Es ist ein Fehler aufgetreten! Bitte melden!');
                        });
                    } else {
                        $('#appointment-show-trainer').text('Zurzeit keiner');
                        $('#appointment-show-dialog').modal('show');
                    }
                },
            });
            $('#calendar').fullCalendar('rerenderEvents');

            $('.timepicker').datetimepicker({
                language: 'de',
                format: _dateFormat+' ' +_timeFormat,
                useCurrent: false,
                sideBySide: true
            });

            $('#appointment-create-dialog [name=wholeDay]').on('change', function() {
                if($(this).is(":checked")) {
                    $('#appointment-create-dialog #end-date-group').addClass('invisible');
                    $('#appointment-create-dialog .timepicker').data().DateTimePicker.format = _dateFormat;
                    $('#appointment-create-dialog .timepicker').data().DateTimePicker.setDate($('#appointment-create-dialog .timepicker').data().DateTimePicker.getDate());
                    $("#appointment-create-dialog #end-date-group input").prop('required', false);
                } else {
                    $('#appointment-create-dialog #end-date-group').removeClass('invisible');
                    $('#appointment-create-dialog .timepicker').data().DateTimePicker.format = _dateFormat+' '+_timeFormat;
                    $('#appointment-create-dialog .timepicker').data().DateTimePicker.setDate($('#appointment-create-dialog .timepicker').data().DateTimePicker.getDate());
                    $("#appointment-create-dialog #end-date-group input").prop('required', true);

                }
            });

            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>

@endsection