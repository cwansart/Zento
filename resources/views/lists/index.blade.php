@extends('main')

@section('title', 'Listen')

@section('content')

    <div class="container-fluid">
        <div class="row">
            {!! Form::open(array('class' => 'form-horizontal', 'method' => 'GET', 'route' => 'lists.create')) !!}

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    {!! Form::submit('Liste erstellen', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}

@endsection