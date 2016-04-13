@extends('main')

@section('title', 'Prüflinge vom '.$exam->date)

@section('content')

    <div class="container">
        <h1>Prüflinge vom {!! $exam->date !!}</h1>

        @if(Auth::user()->is_admin)
            <a class="btn btn-primary pull-right" href="{!! action('ExamController@edit', $exam->id) !!}" role="button">Prüfung bearbeiten</a>
        @endif

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
                <button class="btn btn-default" type="button" id="set-filter">Suchen</button>
            </span>
            </div>
        </div>

        <table class="table table-hover table-exam">
            <thead>
            <tr>
                <th>Vorname <a href="?orderBy={!! 'firstname:' . ($sortBy == 'firstname:ASC' ? 'DESC' : 'ASC') !!}"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes' : 'glyphicon glyphicon-sort-by-attributes-alt' !!}" aria-hidden="true"></span></a></th>
                <th>Nachname <a href="?orderBy={!! 'lastname:' . ($sortBy == 'lastname:ASC' ? 'DESC' : 'ASC') !!}"><span class="glyphicon {!! $sortBy == 'lastname:ASC' ? 'glyphicon glyphicon-sort-by-attributes' : 'glyphicon glyphicon-sort-by-attributes-alt' !!}" aria-hidden="true"></span></a></th>
                <th>Ergebnis</th>
                <th></th>
                @if($filterStatus == -1)
                    <th></th>
                @endif
                @if($filterGroup == -1)
                    <th></th>
                @endif
                <th></th>
                @if(Auth::user()->is_admin)
                    <th>Aktion</th>
                @endif
            </tr>
            </thead>
            <tbody id="userslist">
            @foreach($users as $user)
                <tr class="clickable-row" data-href="{{ action('UserController@show', [$user->user_id]) }}">
                    <td>{!! $user->firstname !!}</td>
                    <td>{!! $user->lastname !!}</td>
                    <td>{!! $user->result !!}</td>

                    @if(is_array($user->latestResultColor($user->result)))
                        <td><div class="zento-result-color-first" style="background: {!! $user->latestResultColor($user->result)[0] !!}"><div class="zento-result-color-second" style="background: {!! $user->latestResultColor($user->result)[1] !!}"></div></div></td>
                    @else
                        <td><div class="zento-result-color-first" style="background: {!! $user->latestResultColor($user->result) !!}"></div></td>
                    @endif

                    @if($filterStatus == -1)
                        @if($user->active)
                            <td><div class="zc-active" data-toggle="tooltip"  data-placement="bottom" title="Aktiv"></div></td>
                        @else
                            <td><div class="zc-inactive" data-toggle="tooltip"  data-placement="bottom" title="Inaktiv"></div></td>
                        @endif
                    @endif

                    @if($filterGroup == -1)
                        @if($user->group_id == 1)
                            <td><div class="zc-adult" data-toggle="tooltip"  data-placement="bottom" title="Erwachsener"></div></td>
                        @else
                            <td><div class="zc-kid" data-toggle="tooltip"  data-placement="bottom" title="Kind"></div></td>
                        @endif
                    @endif

                    @if($user->isTrainer())
                        <td><div class="zc-trainer" data-toggle="tooltip"  data-placement="bottom" title="Trainer"></div></td>
                    @else
                        <td></td>
                    @endif

                    @if(Auth::user()->is_admin)
                        <td>
                            <a href="{!! action('ExamController@removeUser', [$exam->id, $user->id]) !!}" class="delete delete-confirm" title="Prüfling entfernen" data-toggle="tooltip" data-placement="right"></a>
                        </td>
                    @endif
                </tr>
            @endforeach
            @if(Auth::user()->is_admin)
                {!! Form::open(array('id' => 'add-exam-form', 'class' => 'form-horizontal', 'method' => 'PUT', 'action' => array('ExamController@addUser', $exam->id))) !!}
                <tr>
                    <td colspan="2">

                        <select class="form-control select2" id="userid" name="userid">
                            <option value="-1">Benutzer hinzufügen...</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" id="result" name="result" disabled>
                            <option value="-1">Note auswählen...</option>
                            @foreach($results as $id => $name)
                                <option value="{!! $id !!}">{!! $name !!}</option>
                            @endforeach
                        </select>

                    </td>
                </tr>
                {!! Form::close() !!}
            @endif
            </tbody>
        </table>



        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}
    </div>

    {{--
    {!! $seminarUsers->render() !!}
    --}}

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                language: 'de',
                ajax: {
                    url: '{!! action('ExamController@getUnregisteredUsers', [$exam->id]) !!}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        //console.log(params);
                        return {
                            q: params.term, // search term (in input field)
                            page: params.page
                        };
                    },
                    processResults: function(data, page) {
                        return {
                            results: data
                        }
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                minimumInputLength: 1,
                templateResult: function(user) {
                    if(user.loading) return user.text;
                    return '<div class="clearfix"><div>'+user.firstname+' '+ user.lastname +', '+ user.email +' ('+ user.birthday +')</div></div>';
                },
                templateSelection: function(user) {
                    if(user.firstname || user.lastname) {
                        var name = user.firstname + ' ' + user.lastname;
                    }
                    return name || user.text;
                }
            });

            $('.select2').on('select2:select', function(e) {
                $('#result').prop('disabled', false).focus();
            });

            $('#result').on('change', function(e) {
                $('#add-exam-form').submit();
            });

            $('#set-filter').click(function () {
                filter();
            });

            $('#filterS').keypress(function (e) {
                if (e.which == 13) {
                    filter();
                    return false;    //<---- Add this line
                }
            });

            $('[data-toggle="tooltip"]').tooltip();
        });

        function filter() {
            var search = "<?php echo $filterSearch; ?>";
            var group = "<?php echo $filterGroup; ?>";
            var status = "<?php echo $filterStatus; ?>";
            if($('#filterG option:selected').val() != '0' || $('#filterA option:selected').val() != '-1' || $('#filterS').val() != "" || ($('#filterS').val() == "" && search != "") || ($('#filterG option:selected').val() == '0' && group != '0') || ($('#filterA option:selected').val() == '-1' && search != '-1')) {
                window.location.href = '?' + ($('#filterG option:selected').val() != '0' ? 'g=' + $('#filterG option:selected').val() + '&' : '') + ($('#filterA option:selected').val() != '-1' ? 'a=' + $('#filterA option:selected').val() + '&' : '') + ($('#filterS').val() != '' ? 'q=' + $('#filterS').val() : '');
            }
        }
    </script>

@endsection