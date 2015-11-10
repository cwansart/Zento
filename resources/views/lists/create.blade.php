@extends('main')

@section('title', 'Liste erstellen')

@section('content')

    <div class="container">
        <h1>Liste erstellen</h1>

        <button id="submit-list-button" class="pull-right btn btn-primary ">Liste erzeugen</button>


        <div class="btn-group pull-right btn-space-right ">
            <button type="button" id="add-new-column-button" class=" btn btn-default btn-no-border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Spalte hinzufügen <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" id="add-col-address">Adresse</a></li>
                <li><a href="#" id="add-col-birthday">Geburtstag</a></li>
                <li><a href="#" id="add-col-entrydate">Eintrittsdatum</a></li>
                <li><a href="#" id="add-col-group">Gruppe</a></li>
                <li><a href="#" id="add-col-empty">Leere Spalte</a></li>
            </ul>
        </div>

        <table class="table table-hover table-user" id="list-table">
            <thead>
            <tr>
                <th>Vorname <a href="#"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
                <th>Nachname <a href="#"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{!! $user->firstname !!}</td>
                    <td>{!! $user->lastname !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <script>
        // Lädt die Benutzertabelle mit den übergebenen Spalten neu
        function reloadTable(columns, selectedId) {
            var locationIds = new Array();
            $.getJSON('{!! action('UserController@index') !!}', function(users) {
                var newTable = $('<tbody/>').hide();

                // Auslesen der Nutzerdaten und Erstellen einer neuen Tabelle
                users.data.forEach(function(user) {
                    var newRow = $('<tr/>').appendTo(newTable);
                    columns.forEach(function(columnId) {
                        var newColumn = $('<td/>').appendTo(newRow);
                        switch (columnId) {
                            case 'empty': // Hier muss das td leer bleiben
                                break;
                            case 'address': // Die IDs sammeln zum späteren umwandeln
                                newColumn.attr('data-locid', user['location_id']);
                                locationIds.push(user['location_id']);
                                break;
                            default: // Einfach Inhalt einfügen
                                newColumn.append(user[columnId]);
                        }
                    });
                });

                // Einfügen der Locations
                locationIds.forEach(function(locationId) {
                    var getAddressRoute = '{!! action('UserController@getAddress', '') !!}/' + locationId;
                    $.get(getAddressRoute, function(address) {
                        $('#list-table > tbody [data-locid='+locationId+']').append(address).removeAttr('data-locid');
                    });
                });


                // Nun muss noch der neue Tabellenkopf eingefügt werden
                var header = $('<input/>', {
                    'type': 'text'
                });
                switch (selectedId) {
                    case 'address': header = 'Adresse'; break;
                    case 'birthday': header = 'Geburtstag'; break;
                    case 'entry_date': header = 'Eintrittsdatum'; break;
                    case 'group': header = 'Gruppe'; break;
                    default:
                }
                var newHead = $('<th/>', {
                    'html': header
                }).hide();
                $('#list-table > thead th:last-child').after(newHead);
                var oldBody = $('#list-table > tbody');
                $('#list-table').append(newTable);
                oldBody.hide(400, function() {
                    newTable.show(400);
                    newHead.show(400);
                    $(this).remove();
                });
            });
        }

        $(function() {
            // Enthält die aktuell ausgewählten Spalten mit ihren IDs.
            var currentColumns = new Array('firstname', 'lastname');

            // Wenn Adresse hinzugefügt werden soll
            $('#add-col-address').on('click', function() {
                currentColumns.push('address');
                $(this).hide();
                reloadTable(currentColumns, 'address');
            });

            // Wenn der Geburtstag hinzugefügt werden soll
            $('#add-col-birthday').on('click', function() {
                currentColumns.push('birthday');
                $(this).hide();
                reloadTable(currentColumns, 'birthday');
            });

            // Wenn das Eintrittsdatum hinzugefügt werden soll
            $('#add-col-entrydate').on('click', function() {
                currentColumns.push('entry_date');
                $(this).hide();
                reloadTable(currentColumns, 'entry_date');
            });

            // Wenn die Gruppe hinzugefügt werden soll
            $('#add-col-group').on('click', function() {
                currentColumns.push('group');
                $(this).hide();
                reloadTable(currentColumns, 'group');
            });

            // Wenn die Gruppe hinzugefügt werden soll
            $('#add-col-empty').on('click', function() {
                currentColumns.push('empty');
                reloadTable(currentColumns, 'empty');
            });

            // Sendet einen Request an den Server und erstellt dort eine PDF mit der Liste. Anschließend sendet der
            // Server die ID der PDF zurück, damit ein Download-Link angeboten werden kann.
            $('#submit-list-button').on('click', function() {
                var getRequest = $.get('{!! action('ListController@generateList') !!}', { 'currentColumns[]': currentColumns });
                getRequest.done(function(listId) {
                    console.log(listId);
                });
            });
        });
    </script>

@endsection