<button id="buttonClose" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Termin erstellen</button>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Termin erstellen</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                Es gab ein paar Probleme.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {!! Form::open(array('class' => 'form-horizontal', 'method' => 'POST', 'route' => 'appointments.store')) !!}
                        @include('appointments._form')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Termin anlegen', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


    <script>
        $(function() {
            @if(count($errors))
            $('#myModal').modal('show');
            @endif
            $('#buttonClose').on('click', function() {
                        $('#date').val(new Date().toLocaleFormat('%d.%m.%Y'));
                        $('#end_date').val(new Date().toLocaleFormat('%d.%m.%Y'));
                    });

            $('#holeDay').change(function() {
                if( $('#holeDay').is(':checked') )
                {
                    $(".timepicker").addClass('hidden');
                } else {
                    $(".timepicker").removeClass('hidden');
                }
            })
            });
    </script>
