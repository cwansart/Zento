<div class="container-fluid">
    <div class="row">
        {!! Form::open(array('class' => 'form-horizontal', 'method' => 'GET', 'route' => 'lists.create')) !!}

        <div class="form-group">
            {!! Form::label('firstname', 'Vorname', ['class' => 'col-md-4 control-label']) !!}
            <label>
                {!! Form::checkbox('firstname') !!} Sortieren: {!! Form::select('firstnameOrder', array('FIRSTNAME ASC' => 'Aufsteigend', 'FIRSTNAME DESC' => 'Absteigend'), null, ['class' => 'form-control']) !!}
            </label>
        </div>

        <div class="form-group">
            {!! Form::label('lastname', 'Nachname', ['class' => 'col-md-4 control-label']) !!}
            <label>
                {!! Form::checkbox('lastname') !!} Sortieren: {!! Form::select('lastnameOrder', array('LASTNAME ASC' => 'Aufsteigend', 'LASTNAME DESC' => 'Absteigend'), null, ['class' => 'form-control']) !!}
            </label>
        </div>

        <div class="form-group">
            {!! Form::label('email', 'E-Mail', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::checkbox('email') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('emptyColumns', 'Leerspalten', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('number', 'emptyColumns') !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {!! Form::submit('Liste erstellen', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>


        {!! Form::close() !!}
    </div>
</div>