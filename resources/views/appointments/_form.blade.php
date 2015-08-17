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
            {!! Form::input('text', 'end_date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y'), 'required']) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
</div>