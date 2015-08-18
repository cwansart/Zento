<div class="form-group">
    {!! Form::label('title', 'Titel', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('text', 'title', null, ['class' => 'form-control', 'placeholder' => 'Titel', 'required']) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('description', 'Beschreibung', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('text', 'description', null, ['class' => 'form-control', 'rows' => '3', 'placeholder' => 'Beschreibung']) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('date', 'Von', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-4">
        <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
            {!! Form::input('text', 'date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y'), 'required']) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group date timepicker hidden" data-date-format="HH:mm">
            {!! Form::input('text', 'time', null, ['class' => 'form-control', 'placeholder' => 'z. B. 10:00', 'required']) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
        </div>
    </div>
</div>


<div class="form-group">
    {!! Form::label('end_date', 'Bis', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-4">
        <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
            {!! Form::input('text', 'end_date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y'), 'required']) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group date timepicker hidden" data-date-format="HH:mm">
            {!! Form::input('text', 'end_time', null, ['class' => 'form-control', 'placeholder' => 'z. B. 14:00', 'required']) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('holeDay', 'Ganztägig:', ['class' => 'col-md-3 control-label']) !!}

    <div class="col-md-4">
        <div class="input-group checkbox">
            {!! Form::checkbox('holeDay', 1, true,  array('id'=>'holeDay')) !!}
        </div>
    </div>
</div>