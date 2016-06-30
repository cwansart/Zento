<div class="form-group">
    {!! Form::label('firstname', 'Vorname', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('text', 'firstname', null, ['class' => 'form-control', 'placeholder' => 'Vorname', 'required']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('lastname', 'Nachname', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('text', 'lastname', null, ['class' => 'form-control', 'placeholder' => 'Nachname', 'required']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('email', 'E-Mail-Adresse', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => 'Email-Adresse', 'required']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('birthday', 'Geburtstag', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
            {!! Form::input('text', 'birthday', null, ['class' => 'form-control', 'placeholder' => 'z. B. 01.07.1985']) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('entry_date', 'Eintrittsdatum', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
            {!! Form::input('text', 'entry_date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y')]) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
</div>

@include('location_input')

<div class="form-group">
    {!! Form::label('group_id', 'Gruppe', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('group_id', $groups, null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4"></div>

    <div class="col-md-6">
        <div class="checkbox">
            <label>
                {!! Form::checkbox('active', 1, $active_state) !!} Aktives Mitglied?
            </label>
        </div>
    </div>
</div>
