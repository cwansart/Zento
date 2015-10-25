<div class="container-fluid">
    <div class="row">
        {!! Form::open(array('class' => 'form-horizontal', 'method' => 'GET', 'route' => 'lists.create')) !!}

        <table class="table table-hover table-user">
            <thead>
            <tr>
                <th>Vorname <a href="#"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
                <th>Nachname <a href="#"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
                <th>
                    <a href="#" id="add-new-column"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Spalte hinzufügen"></span></a>

                    <div id="add-new-column-input">
                        <select>
                            <option>Adresse</option>
                            <option>Geburtsdatum</option>
                            <option>Eintrittsdatum</option>
                            <option>Gruppe</option>
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

        {!! Form::close() !!}
    </div>

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

        table > thead > tr > th:last-child > div#add-new-column-input {
            display: none;
        }
    </style>

    <script>
        $(function() {
            // Tooltips aktivieren
            $('[data-toggle="tooltip"]').tooltip();

            $('#add-new-column').on('click', function() {
                $(this).hide(400);
                $(this).parent().children('div').show(400);
            });
        });
    </script>
</div>