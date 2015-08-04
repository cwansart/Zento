<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Benutzer erstellen</div>
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

                    {!! Form::open(array('class' => 'form-horizontal', 'method' => 'POST', 'route' => 'users.store')) !!}
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
                        {!! Form::label('email', 'Email-Adresse', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => 'Email-Adresse', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Passwort', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => 'Leer lassen zum Deaktivieren']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('birthday', 'Geburtstag', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
                                {!! Form::input('text', 'birthday', null, ['class' => 'form-control', 'placeholder' => 'z. B. 01.07.1985']) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('entry_date', 'Eintrittsdatum', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
                                {!! Form::input('text', 'entry_date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y')]) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"</span>
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
                                    {!! Form::checkbox('active', 1, true) !!} Aktives Mitglied?
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {!! Form::submit('Benutzer anlegen', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>