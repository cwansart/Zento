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
                        {!! Form::open(array('id' => 'appointments_dialog', 'class' => 'form-horizontal',
                        'method' => 'POST', 'route' => 'appointments.store')) !!}
                        {!! Form::hidden('_method', 'POST') !!}

                        @include('appointments._form')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
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


    <script>
        $(function() {
            @if(count($errors))
            $('#createModal').modal('show');
            @endif
            $('#buttonCreate').on('click', function() {
                        $('#appointments_dialog').attr('action', '{!! action('AppointmentController@store') !!}');
                        $('[name=_method]').val('POST');
                        $('#modal_title').html('Termin erstellen');
                        clear();
                    });

            $('#holeDay').change(function() {
                showTime();
            })
            });
    </script>
