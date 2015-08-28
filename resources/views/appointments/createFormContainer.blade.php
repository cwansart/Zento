<div class="container-fluid">
    <div class="row">
        {!! Form::open(array('class' => 'form-horizontal', 'method' => 'POST', 'route' => 'appointments.store')) !!}
        @include('appointments._form')

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {!! Form::submit('Termin anlegen', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>