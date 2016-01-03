@extends('main')

@section('title', 'Teilnehmer „'.$seminar->title.'“')

@section('content')

    <div class="container">
        <h1>Teilnehmer des Seminars „{!! $seminar->title !!}“</h1>

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

        <table class="table table-hover table-seminar">
            <thead>
            <tr>
                <th>Vorname <a href="{!! action('SeminarController@show', ['orderBy' => 'firstname:' . ($sortBy == 'firstname:ASC' ? 'DESC' : 'ASC')]) !!}"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes' : 'glyphicon glyphicon-sort-by-attributes-alt' !!}" aria-hidden="true"></span></a></th>
                <th>Nachname <a href="{!! action('SeminarController@show', ['orderBy' => 'lastname:' . ($sortBy == 'lastname:ASC' ? 'DESC' : 'ASC')]) !!}"><span class="glyphicon {!! $sortBy == 'lastname:ASC' ? 'glyphicon glyphicon-sort-by-attributes' : 'glyphicon glyphicon-sort-by-attributes-alt' !!}" aria-hidden="true"></span></a></th>
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
            <tbody>
            @foreach($users as $user)
                <tr class="clickable-row" data-href="{{ action('UserController@show', [$user->id]) }}">
                    <td>{!! $user->firstname !!}</td>
                    <td>{!! $user->lastname !!}</td>

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
                            <a href="{!! action('SeminarController@destroy', [$seminar->id, $user->id]) !!}" class="delete delete-confirm" title="Teilnehmer entfernen" data-toggle="tooltip" data-placement="right"></a>
                        </td>
                    @endif
                </tr>
            @endforeach

            @if(Auth::user()->is_admin)
                <tr>
                    <td colspan="3">
                        {!! Form::open(array('id' => 'add-seminar-form', 'class' => 'form-horizontal', 'method' => 'PUT', 'action' => array('SeminarController@addUser', $seminar->id))) !!}
                        <select class="form-control select2" id="userid" name="userid">
                            <option value="-1">Benutzer hinzufügen...</option>
                        </select>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>

        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                language: 'de',
                ajax: {
                    url: '{!! action('SeminarController@getUnregisteredUsers', [$seminar->id]) !!}',
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
                    //var birthday = new Date(user.birthday.split(' ')[0]);
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
                $('#add-seminar-form').submit();
            });
        });
    </script>

    {{--
    {!! $seminarUsers->render() !!}
    --}}

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@endsection