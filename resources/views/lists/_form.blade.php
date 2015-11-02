<table class="table table-hover table-user" id="list-table">
    <thead>
    <tr>
        <th>Vorname <a href="#"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
        <th>Nachname <a href="#"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
        <th>
            <a href="#" id="add-new-column"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Spalte hinzufügen"></span></a>

            <div id="add-new-column-input">
                <select id="new-column-select">
                    <option value="-1">Bitte auswählen</option>
                    <option value="address">Adresse</option>
                    <option value="birthday">Geburtsdatum</option>
                    <option value="entry_date">Eintrittsdatum</option>
                    <option value="group">Gruppe</option>
                    <option value="empty">Leere Spalte</option>
                </select>
            </div>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{!! $user->firstname !!}</td>
            <td>{!! $user->lastname !!}</td>
            <td></td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3" style="line-height: 20px; font-size: 48px; font-weight: bold; text-align: center">...</td>
    </tr>
    </tbody>
</table>

<style>
    table > thead > tr > th {
        /*width: 33%;*/
    }

    table > thead > tr > th:last-child {
        position: relative;
    }

    table > thead > tr > th:last-child > a#add-new-column,
    table > thead > tr > th:last-child > div#add-new-column-input {
        position: absolute;
        top: 7px;
        left: 0;
    }

    /* initiales Ausblenden des Auswahlfeldes */
    table > thead > tr > th:last-child > div#add-new-column-input {
        display: none;
    }
</style>

<script>
    $(function() {
        // Tooltips aktivieren.
        $('[data-toggle="tooltip"]').tooltip();

        // Enthält die aktuell ausgewählten Spalten mit ihren IDs.
        var currentColumns = new Array('firstname', 'lastname');

        // Fügt ein leeres Element hinzu.
        function addEmpty() {
            currentColumns.push('empty');
        }

        // Wenn das + Icon geklickt wurde
        $('#add-new-column').on('click', function() {
            $(this).hide(400);
            $('#add-new-column-input').show(400);
        });

        // Wenn die Auswahl getätigt wurde.
        $('#new-column-select').on('change', function() {
            var selectedId = $(this).val();
            switch (selectedId) {
                case 'address': // Adresse
                case 'birthday': // Geburtsdatum
                case 'entry_date':
                case 'group':
                        currentColumns.push(selectedId);
                    break;
                default:
                    addEmpty();
            }

            // Daten vom Server auslesen.
            var locationIds = new Array();
            $.getJSON('{!! action('UserController@index') !!}', function(users) {
                var newTable = $('<tbody/>').hide();

                // Auslesen der Nutzerdaten und Erstellen einer neuen Tabelle
                users.data.forEach(function(user) {
                    var newRow = $('<tr/>').appendTo(newTable);
                    currentColumns.forEach(function(columnId) {
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
                    newRow.append($('<td/>'));
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
                $('#list-table > thead th:last-child').before(newHead);

                var oldBody = $('#list-table > tbody');
                $('#list-table').append(newTable);
                oldBody.hide(400, function() {
                    newTable.show(400);
                    newHead.show(400);
                    $(this).remove();
                });

            });

            // Auswahl verstecken.
            $(this).parent().hide(400);
            $('#add-new-column').show(400);

            // Auswahl wieder aufheben
            var selectedOption = $(this).children(':selected');
            selectedOption.removeAttr('selected');

            // Elemente außer "Leere Spalte" sollen versteckt werden, damit sie nicht mehrfach hinzugefügt werden.
            if(selectedId != 'empty') selectedOption.hide();
        });
    });
</script>