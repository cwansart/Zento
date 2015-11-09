<div class="container">
    <table>
        <tr>
            <td>
                {!! Form::select('a', array(-1 => 'Alle Mitglieder', 0 => 'Nur Inaktive', 1 => 'Nur Aktive'), $filterStatus, ['class' => 'form-control', 'id' => 'filterA']) !!}
            </td>
            <td>
                {!! Form::select('g_id', array_merge(array(-1 => 'Alle Gruppen'), $groups), $filterGroup, ['class' => 'form-control', 'id' => 'filterG']) !!}
            </td>
            <td>
                <div class="input-group">
                    {!! Form::input('text', 's', $filterSearch, ['class' => 'form-control', 'id' => 'filterS', 'placeholder' => 'Suche...']) !!}
                    <span class="input-group-btn"><button class="btn btn-default" id="set-filter" type="button">Los!</button></span>
                </div>
            </td>
        </tr>
    </table>
</div>