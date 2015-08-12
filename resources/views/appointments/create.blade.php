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
                        <div class="col-md-4"></div>

                        <div class="col-md-6">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('holeDay', 1, true,  array('id'=>'holeDay')) !!} Ganztägig?
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group time hidden">
                        {!! Form::label('date', 'Von', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY HH:mm">
                                {!! Form::input('text', 'date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y H:i'), 'required']) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group time hidden">
                        {!! Form::label('end_date', 'Bis', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY HH:mm">
                                {!! Form::input('text', 'entry_date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y H:i'), 'required']) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group date">
                        {!! Form::label('date', 'Von', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
                                {!! Form::input('text', 'date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y'), 'required']) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group date">
                        {!! Form::label('end_date', 'Bis', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
                                {!! Form::input('text', 'entry_date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y'), 'required']) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#holeDay').change(function() {
            if( $('#holeDay').is(':checked') )
            {
                console.log('true');
                $(".time").addClass('hidden');
                $(".date").removeClass('hidden');
            }  else {
                console.log('false');
                $(".date").addClass('hidden');
                $(".time").removeClass('hidden');
            }
        })
    });
</script>