<div class="container">
    <table>
        <row>
            <td>
                {!! Form::select('g_id', array_merge(array(-1 => 'Gruppe'), $groups), $filterGroup, ['class' => 'form-control', 'id' => 'filterG']) !!}
            </td>
            <td>
                {!! Form::select('a', array(-1 => 'Status', 0 => 'Inaktiv', 1 => 'Aktiv'), $filterStatus, ['class' => 'form-control', 'id' => 'filterA']) !!}
            </td>
            <td>
                {!! Form::input('text', 's', $filterSearch, ['class' => 'form-control', 'id' => 'filterS', 'placeholder' => 'Suche...']) !!}
            </td>
            <td>
                <span class="input-group-btn">
                    <button class="btn btn-default" id="set-filter" type="button"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </td>
        </row>
    </table>
</div>