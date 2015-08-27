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
                        {!! Form::submit('Termin speichern', ['class' => 'btn btn-primary']) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        {!! Form::open(['action' => ['UserController@destroy', null], 'method' => 'DELETE', 'class' => ' pull-right', 'id' => 'delform']) !!}
                        {!! Form::submit('', ['class' => 'delete', 'title' => 'Termin löschen', 'data-toggle' => 'tooltip', 'data-placement' => 'left']) !!}
                        {!! Form::close() !!}
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id='modal_title' class="modal-title">Termin bearbeiten</h4>
                    </div>


                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">

                                {!! Form::open(array('id' => 'appointment-edit-dialog', 'class' => 'form-horizontal', 'method' => 'PUT', 'route' => 'appointments.update')) !!}
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
                    $('#appointment-edit-dialog').attr('action', storeRoute);

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

                    // clear form
                    $('#editModal form')[0].reset();

                    // fill modal dialog with data
                    var updateRoute = '{!! action('AppointmentController@update', null) !!}';
                    $('#appointment-edit-dialog').attr('action', updateRoute+'/'+event.id);

                    var destroyRoute = '{!! action('AppointmentController@destroy', null) !!}';
                    $('#delform').attr('action', destroyRoute+'/'+event.id);

                    $('#appointment-edit-dialog [name=title]').val(event.title);
                    $('#appointment-edit-dialog [name=description]').val(event.description);
                    $('#appointment-edit-dialog [name=date]').val(start_date);
                    $('#appointment-edit-dialog [name=end_date]').val(end_date);
                    $('#appointment-edit-dialog [name=wholeDay]').prop('checked', event.allDay);

                    if(event.user_id) {
                        $('#appointment-edit-dialog #current-trainer').val(event.user_id);
                        $('#appointment-edit-dialog #current-trainer-info span').text('Lord Helmchen');

                        // Dynamically load the user data 'cause we don't have it all the time. May not work, that's
                        // why I set a default value.
                        $.getJSON('{!! action('UserController@show', null) !!}/'+event.user_id, function(trainer) {
                            $('#appointment-edit-dialog #current-trainer-info span').text(trainer.firstname+' '+trainer.lastname);
                        });
                    } else {
                        $('#appointment-edit-dialog #current-trainer').val(-1);
                        $('#appointment-edit-dialog #current-trainer-info span').text('Keiner');
                    }

                    if(event.allDay) {
                        $('#appointment-edit-dialog #end-date-group').addClass('invisible');
                        $("#appointment-edit-dialog #end-date-group input").prop('required', false);
                    } else {
                        $('#appointment-edit-dialog #end-date-group').removeClass('invisible');
                        $("#appointment-edit-dialog #end-date-group input").prop('required', true);
                    }

                    $('#editModal').modal('show');
                },
            });
            $('#calendar').fullCalendar('rerenderEvents');

            $('.timepicker').datetimepicker({
                language: 'de',
                format: _dateFormat+' ' +_timeFormat,
                useCurrent: false,
                sideBySide: true
            });

            $('#appointment-edit-dialog [name=wholeDay]').on('change', function() {
                if($(this).is(":checked")) {
                    $('#appointment-edit-dialog #end-date-group').addClass('invisible');
                    $('#appointment-edit-dialog .timepicker').data().DateTimePicker.format = _dateFormat;
                    $('#appointment-edit-dialog .timepicker').data().DateTimePicker.setDate($('#appointment-edit-dialog .timepicker').data().DateTimePicker.getDate());
                    $("#appointment-edit-dialog #end-date-group input").prop('required', false);
                } else {
                    $('#appointment-edit-dialog #end-date-group').removeClass('invisible');
                    $('#appointment-edit-dialog .timepicker').data().DateTimePicker.format = _dateFormat+' '+_timeFormat;
                    $('#appointment-edit-dialog .timepicker').data().DateTimePicker.setDate($('#appointment-edit-dialog .timepicker').data().DateTimePicker.getDate());
                    $("#appointment-edit-dialog #end-date-group input").prop('required', true);
                }
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

            $('#buttonCreate').on('click', function() {
                $('#createModal form')[0].reset();
            });

            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>

@endsection