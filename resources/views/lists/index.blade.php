@extends('main')

@section('title', 'Listen')

@section('content')

    <div class="container">
        <h1>Listen</h1>

        <button type="button" class="btn btn-primary pull-right" id="list-create-button">Liste erstellen</button>
        <div class="clearfix"></div>

        <div class="row">
            Listen sind zum Ausdrucken gedacht. Sie können zuvor beliebig angepasst werden, zum Beispiel in dem neben den
            Vor- und Nachnamen noch Gruppen oder das Alter stehen. Außerdem können beliebig viele leere Spalten und Zeilen
            erzeugt werden. Anschließend wird eine PDF-Datei zum Download angeboten, sodass die Liste ausgedruck werden kann.
        </div>
    </div>

    <script>
        $(function() {
            $('#list-create-button').on('click', function() {
                window.location = '{!! route('lists.create') !!}';
            });
        });
    </script>

@endsection