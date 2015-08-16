<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Seminar erstellen</button>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Seminar erstellen</h4>
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

                        {!! Form::open(array('class' => 'form-horizontal', 'method' => 'POST', 'route' => 'seminars.store')) !!}
                        @include('location_input')

                        <div class="form-group">
                            {!! Form::label('title', 'Titel', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                {!! Form::input('text', 'title', null, ['class' => 'form-control', 'placeholder' => 'Titel', 'required']) !!}
                            </div>
                        </div>
                            
                        <div class="form-group">
                            {!! Form::label('date', 'Datum', ['class' => 'col-md-4 control-label']) !!}
                            <div class="col-md-6">
                                <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
                                    {!! Form::input('text', 'date', null, ['class' => 'form-control', 'placeholder' => 'z. B. 01.07.1985']) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Seminar anlegen', ['class' => 'btn btn-primary']) !!}
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
@if(count($errors))
    <script>
        $(function() {
            $('#myModal').modal('show');
        });
    </script>
@endif
