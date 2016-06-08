@extends('main')

@section('title', 'Liste erstellen')

@section('content')

    <div class="container">
        <h1>Liste erstellen</h1>

        <button id="submit-list-button" class="pull-right btn btn-primary ">Liste erzeugen</button>

        <div class="form-inline">
            <div class="input-group">
                {!! Form::select('a', array(-1 => 'Alle Mitglieder', 0 => 'Nur Inaktive', 1 => 'Nur Aktive'), $filterStatus, ['class' => 'form-control', 'id' => 'filterA']) !!}
            </div>

            <div class="input-group">
                {!! Form::select('g_id', array_merge(array(-1 => 'Alle Gruppen'), $groups), $filterGroup, ['class' => 'form-control', 'id' => 'filterG']) !!}
            </div>
            <div class="input-group">
                {!! Form::input('text', 's', $filterSearch, ['class' => 'form-control', 'id' => 'filterS', 'placeholder' => 'Suche...']) !!}
                <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="set-filter-btn">Suchen</button>
            </span>
            </div>
        </div>

        <div style="margin-top: 22px">
            <div class="btn-group pull-right btn-space-right ">
                <button type="button" id="add-new-column-button" class=" btn btn-default btn-no-border dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

            <div class="form-inline">
                <div class="input-group">
                    {!! Form::text('listtitle', null, ['maxlength' => 50, 'class' => 'form-control', 'id' => 'listtitle', 'placeholder' => 'Listentitel', 'style' => 'width: 370px;']) !!}
                </div>
            </div>
        </div>

        <table class="table table-hover table-user" id="list-table">
            <thead>
            <tr>
                <th>Vorname <a id="sortFirstname" href="#"><span
                                class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}"
                                aria-hidden="true"></span></a></th>
                <th>Nachname <a id="sortLastname" href="#"><span
                                class="glyphicon {!! $sortBy == 'lastname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}"
                                aria-hidden="true"></span></a></th>
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

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Liste bereit zum Herunterladen</h4>
                </div>
                <div class="modal-body">
                    Die erzeugte Liste ist nun zum Herunterladen bereit. Um den Download zu beginnen, einfach die
                    folgende Schaltfläche anklicken:<br><br>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" id="list-download-button">Liste als PDF
                            herunterladen
                        </button>
                    </div>
                    <iframe id="download_iframe" style="display: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-no-border" data-dismiss="modal">Schließen</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Lädt die Benutzertabelle mit den übergebenen Spalten neu
        function reloadTable(columns, selectedId) {
            var locationIds = new Array();
            $.getJSON('{!! action('UserController@index') !!}', function (users) {
                var newTable = $('<tbody/>').hide();

                // Auslesen der Nutzerdaten und Erstellen einer neuen Tabelle
                users.data.forEach(function (user) {
                    var newRow = $('<tr/>').appendTo(newTable);
                    columns.forEach(function (columnId) {
                        var newColumn = $('<td/>').appendTo(newRow);
                        switch (columnId) {
                            case 'empty': // Hier muss das td leer bleiben
                                break;
                            case 'address': // Die IDs sammeln zum späteren umwandeln
                                newColumn.attr('data-locid', user['location_id']);
                                locationIds.push(user['location_id']);
                                break;
                            case 'group':
                                newColumn.append(user.group_id == 1 ? 'Erwachsene' : 'Kinder');
                                break;
                            default: // Einfach Inhalt einfügen
                                newColumn.append(user[columnId]);
                        }
                    });
                });

                // Einfügen der Locations
                locationIds.forEach(function (locationId) {
                    var getAddressRoute = '{!! action('UserController@getAddress', '') !!}/' + locationId;
                    $.get(getAddressRoute, function (address) {
                        $('#list-table > tbody [data-locid=' + locationId + ']').append(address).removeAttr('data-locid');
                    });
                });


                // Nun muss noch der neue Tabellenkopf eingefügt werden
                var header = $('<input/>', {
                    'type': 'text',
                    'class': 'list-head-input empty',
                    'placeholder': 'leer'
                });
                switch (selectedId) {
                    case 'address':
                        header = 'Adresse';
                        break;
                    case 'birthday':
                        header = 'Geburtstag';
                        break;
                    case 'entry_date':
                        header = 'Eintrittsdatum';
                        break;
                    case 'group':
                        header = 'Gruppe';
                        break;
                    default:
                }
                var newHead = $('<th/>', {
                    'html': header
                }).hide();
                $('#list-table > thead th:last-child').after(newHead);
                var oldBody = $('#list-table > tbody');
                $('#list-table').append(newTable);
                oldBody.hide(400, function () {
                    newTable.show(400);
                    newHead.show(400);
                    $(this).remove();
                });
            });
        }

        // Lädt die Benutzertabelle mit der übergebenen Sortierung neu
        function reloadTableOrderedBy(columns, orderBy) {
            var locationIds = new Array();
            $.getJSON('{!! action('UserController@index', ['orderBy', '']) !!}=' + orderBy, function (users) {
                console.log(orderBy);
                console.log(users);
                var newTable = $('<tbody/>').hide();

                // Auslesen der Nutzerdaten und Erstellen einer neuen Tabelle
                users.data.forEach(function (user) {
                    var newRow = $('<tr/>').appendTo(newTable);
                    columns.forEach(function (columnId) {
                        var newColumn = $('<td/>').appendTo(newRow);
                        switch (columnId) {
                            case 'empty': // Hier muss das td leer bleiben
                                break;
                            case 'address': // Die IDs sammeln zum späteren umwandeln
                                newColumn.attr('data-locid', user['location_id']);
                                locationIds.push(user['location_id']);
                                break;
                            case 'group':
                                newColumn.append(user.group_id == 1 ? 'Erwachsene' : 'Kinder');
                                break;
                            default: // Einfach Inhalt einfügen
                                newColumn.append(user[columnId]);
                        }
                    });
                });

                // Einfügen der Locations
                locationIds.forEach(function (locationId) {
                    var getAddressRoute = '{!! action('UserController@getAddress', '') !!}/' + locationId;
                    $.get(getAddressRoute, function (address) {
                        $('#list-table > tbody [data-locid=' + locationId + ']').append(address).removeAttr('data-locid');
                    });
                });

                var oldBody = $('#list-table > tbody');
                $('#list-table').append(newTable);
                oldBody.hide(400, function () {
                    newTable.show(400);
                    newHead.show(400);
                    $(this).remove();
                });
            });
        }

        function reloadTableSearch(columns, orderBy, searchParameters) {
            var locationIds = new Array();

            $.getJSON('{!! action('UserController@index', ['orderBy', '']) !!}=' + orderBy + searchParameters, function (users) {
                console.log(orderBy);
                console.log(users);
                var newTable = $('<tbody/>').hide();

                // Auslesen der Nutzerdaten und Erstellen einer neuen Tabelle
                users.data.forEach(function (user) {
                    var newRow = $('<tr/>').appendTo(newTable);
                    columns.forEach(function (columnId) {
                        var newColumn = $('<td/>').appendTo(newRow);
                        switch (columnId) {
                            case 'empty': // Hier muss das td leer bleiben
                                break;
                            case 'address': // Die IDs sammeln zum späteren umwandeln
                                newColumn.attr('data-locid', user['location_id']);
                                locationIds.push(user['location_id']);
                                break;
                            case 'group':
                                newColumn.append(user.group_id == 1 ? 'Erwachsene' : 'Kinder');
                                break;
                            default: // Einfach Inhalt einfügen
                                newColumn.append(user[columnId]);
                        }
                    });
                });

                // Einfügen der Locations
                locationIds.forEach(function (locationId) {
                    var getAddressRoute = '{!! action('UserController@getAddress', '') !!}/' + locationId;
                    $.get(getAddressRoute, function (address) {
                        $('#list-table > tbody [data-locid=' + locationId + ']').append(address).removeAttr('data-locid');
                    });
                });

                var oldBody = $('#list-table > tbody');
                $('#list-table').append(newTable);
                oldBody.hide(400, function () {
                    newTable.show(400);
                    newHead.show(400);
                    $(this).remove();
                });
            });
        }

        $(function () {
            // Enthält die aktuell ausgewählten Spalten mit ihren IDs.
            var currentColumns = new Array('firstname', 'lastname');
            var emptyColumns = [];
            var searchParameters = '';

            // Wenn Adresse hinzugefügt werden soll
            $('#add-col-address').on('click', function () {
                currentColumns.push('address');
                $(this).hide();
                reloadTable(currentColumns, 'address');
            });

            // Wenn der Geburtstag hinzugefügt werden soll
            $('#add-col-birthday').on('click', function () {
                currentColumns.push('birthday');
                $(this).hide();
                reloadTable(currentColumns, 'birthday');
            });

            // Wenn das Eintrittsdatum hinzugefügt werden soll
            $('#add-col-entrydate').on('click', function () {
                currentColumns.push('entry_date');
                $(this).hide();
                reloadTable(currentColumns, 'entry_date');
            });

            // Wenn die Gruppe hinzugefügt werden soll
            $('#add-col-group').on('click', function () {
                currentColumns.push('group');
                $(this).hide();
                reloadTable(currentColumns, 'group');
            });

            // Wenn die Gruppe hinzugefügt werden soll
            $('#add-col-empty').on('click', function () {
                currentColumns.push('empty');
                reloadTable(currentColumns, 'empty');
            });

            // Sendet einen Request an den Server und erstellt dort eine PDF mit der Liste. Anschließend sendet der
            // Server die ID der PDF zurück, damit ein Download-Link angeboten werden kann.
            $('#submit-list-button').on('click', function () {
                $('#myModal').modal('show');
            });

            // Speichert die aktuelle Sortierung, damit diese in den ListController übertragen werden kann.
            var orderBy = 'firstname:ASC';

            // Startet den Download
            $('#list-download-button').on('click', function () {
                emptyColumns = [];
                $('.empty').each(function (index, element) {
                    emptyColumns.push(element.value);
                });


                var downloadUrl = '{!! action('ListController@generateList') !!}?'
                        + '&' + $.param({'currentColumns[]': currentColumns})
                        + '&' + $.param({'emptyColumns[]': emptyColumns})
                        + '&' + $.param({'orderBy': orderBy})
                        + searchParameters;

                // Füge Listentitel hinzu, falls Eingabefeld nicht leer ist.
                if ($('#listtitle').val().length > 0) {
                    downloadUrl += '&' + $.param({'listtitle': $('#listtitle').val()});
                }

                $('#download_iframe').attr('src', downloadUrl);

            });

            $('#sortFirstname').on('click', function () {
                var sortIcon = $($(this).children()[0]);
                if (sortIcon.hasClass('glyphicon-sort-by-attributes')) {
                    sortIcon.removeClass('glyphicon-sort-by-attributes');
                    sortIcon.addClass('glyphicon-sort-by-attributes-alt');
                    orderBy = 'firstname:DESC';
                    reloadTableOrderedBy(currentColumns, orderBy);
                } else {
                    sortIcon.removeClass('glyphicon-sort-by-attributes-alt');
                    sortIcon.addClass('glyphicon-sort-by-attributes');
                    orderBy = 'firstname:ASC';
                    reloadTableOrderedBy(currentColumns, orderBy);
                }
            });

            $('#sortLastname').on('click', function () {
                var sortIcon = $($(this).children()[0]);
                if (sortIcon.hasClass('glyphicon-sort-by-attributes')) {
                    sortIcon.removeClass('glyphicon-sort-by-attributes');
                    sortIcon.addClass('glyphicon-sort-by-attributes-alt');
                    orderBy = 'lastname:DESC';
                    reloadTableOrderedBy(currentColumns, orderBy);
                } else {
                    sortIcon.removeClass('glyphicon-sort-by-attributes-alt');
                    sortIcon.addClass('glyphicon-sort-by-attributes');
                    orderBy = 'lastname:ASC';
                    reloadTableOrderedBy(currentColumns, orderBy);
                }
            });

            $('#set-filter-btn').on('click', function () {
                var active = parseInt($('#filterA').val());
                var group = parseInt($('#filterG').val());
                var searchterm = $('#filterS').val();

                if (active >= 0) searchParameters += '&a=' + active;
                if (group >= 0) searchParameters += '&g=' + group;
                if (searchterm.length > 0) searchParameters += '&q=' + searchterm;
                reloadTableSearch(currentColumns, orderBy, searchParameters);
            });
        });
    </script>

@endsection