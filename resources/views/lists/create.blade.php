@extends('main')

@section('title', 'Liste erstellen')

@section('content')

    <div class="container">
        <h2>Liste erstellen</h2>
        {!! Form::open(array('class' => 'form-horizontal', 'method' => 'GET', 'route' => 'lists.create')) !!}
        @include('lists._form')
        {!! Form::close() !!}
    </div>

    {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}

@endsection