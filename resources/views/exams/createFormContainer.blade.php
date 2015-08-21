<div class="container-fluid">
    <div class="row">
        {!! Form::open(array('class' => 'form-horizontal', 'method' => 'POST', 'route' => 'exams.store')) !!}
        @include('exams._form')

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {!! Form::submit('Prüfung anlegen', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}

    </div>
</div>