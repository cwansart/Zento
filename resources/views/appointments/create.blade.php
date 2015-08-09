<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Termin erstellen</div>
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

                    {!! Form::open(array('class' => 'form-horizontal', 'method' => 'POST', 'route' => 'appointments.store')) !!}
                    <div class="form-group">
                        {!! Form::label('title', 'Titel', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::input('text', 'title', null, ['class' => 'form-control', 'placeholder' => 'Titel', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('date', 'Von', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
                                {!! Form::input('text', 'date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y').' oder '.date('d.m.Y H:i'), 'required']) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('end_date', 'Eintrittsdatum', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
                                {!! Form::input('text', 'entry_date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y')]) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"</span>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>