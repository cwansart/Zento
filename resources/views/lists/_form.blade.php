
        <table class="table table-hover table-user">
            <thead>
            <tr>
                <th>Vorname <a href="#"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
                <th>Nachname <a href="#"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
                <th>
                    <a href="#" id="add-new-column"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Spalte hinzufügen"></span></a>

                    <div id="add-new-column-input">
                        <select id="new-column-select">
                            <option value="-1">Bitte auswählen</option>
                            <option value="0">Adresse</option>
                            <option value="1">Geburtsdatum</option>
                            <option value="2">Eintrittsdatum</option>
                            <option value="3">Gruppe</option>
                            <option value="4">Leere Spalte</option>
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
            width: 33%;
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
            // Tooltips aktivieren
            $('[data-toggle="tooltip"]').tooltip();

            // Wenn das + Icon geklickt wurde
            $('#add-new-column').on('click', function() {
                $(this).hide(400);
                $('#add-new-column-input').show(400);
            });

            // Wenn die Auswahl getätigt wurde
            $('#new-column-select').on('change', function() {
                var selectedId = $(this).val();
                switch (selectedId) {
                    case 0: // Adresse
                        break;
                    case 1: // Geburtsdatum
                        break;
                    case 2: // Eintrittsdatum
                        break;
                    case 3: // Gruppe
                        break;
                    case 4: // Leere Spalte
                        break;
                    default:
                }

                // Auswahl verstecken
                $(this).parent().hide(400);
                $('#add-new-column').show(400);

                // Auswahl wieder aufheben
                $(this).children(':selected').removeAttr('selected');
            });
        });
    </script>