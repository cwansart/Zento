<div class="form-inline">
        <div class="input-group">
            {!! Form::select('a', array(-1 => 'Alle Mitglieder', 0 => 'Nur Inaktive', 1 => 'Nur Aktive'), $filterStatus, ['class' => 'form-control', 'id' => 'filterA']) !!}
        </div>

        <div class="input-group">
            {!! Form::select('g_id', array_merge(array(-1 => 'Alle Gruppen'), $groups), $filterGroup, ['class' => 'form-control', 'id' => 'filterG']) !!}
        </div>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
            </span>
        </div>
</div>