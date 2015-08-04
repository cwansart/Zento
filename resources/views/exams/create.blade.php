<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Prüfung erstellen</div>
                <div class="panel-body">
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

                    {!! Form::open(array('class' => 'form-horizontal', 'method' => 'POST', 'route' => 'exams.store')) !!}
                    @include('location_input')

                    {{-- TODO: Müssen wir hier nicht besser datetime verwenden? Falls ja, müssen wir auch die Migration
                               anpassen und dort dateTime() anstelle von date() verwenden. --}}
                    <div class="form-group">
                        {!! Form::label('date', 'Datum', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
                                {!! Form::input('text', 'date', null, ['class' => 'form-control', 'placeholder' => 'z. B. 01.07.1985']) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {!! Form::submit('Prüfung anlegen', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>