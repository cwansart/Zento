@extends('main')

@section('title', 'Listen')

@section('content')

    <div class="container">
        <h1 class="h1-index">Listen</h1>

        <button type="button" class="btn btn-primary pull-right btn-create">Liste erstellen</button>
        <div class="clearfix"></div>

        Listen sind zum Ausdrucken gedacht. Sie können zuvor beliebig angepasst werden, zum Beispiel in dem neben den
        Vor- und Nachnamen noch Gruppen oder das Alter stehen. Außerdem können beliebig viele leere Spalten und Zeilen
        erzeugt werden. Anschließend wird eine PDF-Datei zum Download angeboten, sodass die Liste ausgedruck werden kann.
    </div>

@endsection