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
