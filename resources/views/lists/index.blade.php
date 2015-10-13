@extends('main')

@section('title', 'Listen')

@section('content')

    <div class="container">
        <h2>Liste erstellen</h2>
        @include('lists._form')
    </div>

    {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}

@endsection