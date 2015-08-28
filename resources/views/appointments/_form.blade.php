<div class="form-group">
    {!! Form::label('title', 'Titel', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('text', 'title', null, ['class' => 'form-control', 'placeholder' => 'Titel', 'required']) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('description', 'Beschreibung', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('text', 'description', null, ['class' => 'form-control', 'rows' => '3', 'placeholder' => 'Beschreibung']) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('date', 'Von', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-6">
        <div class="input-group date timepicker">
            {!! Form::input('text', 'date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y'), 'required']) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
</div>


<div class="form-group" id="end-date-group">
    {!! Form::label('end_date', 'Bis', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-6">
        <div class="input-group date timepicker">
            {!! Form::input('text', 'end_date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y'), 'required']) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('wholeDay', 'Ganztägig', ['class' => 'col-md-3 control-label']) !!}

    <div class="col-md-6">
        <div class="input-group checkbox">
            {!! Form::checkbox('wholeDay', 0, false,  array('id'=>'wholeDay', 'style' => 'margin-left:0 !important')) !!}
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_id', 'Trainer', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-6">
        <select class="form-control select2" id="user_id" name="user_id">
            <option id="current-trainer" value="-1">Trainer hinzufügen...</option>
        </select>
    </div>
</div>


<script>
    $(document).ready(function() {
        $(".select2").select2({
            language: 'de',
            ajax: {
                url: '{!! action('UserController@index') !!}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: data.data
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: function(user) {
                if(user.loading) return user.text;
                return '<div class="clearfix"><div>'+user.firstname+' '+ user.lastname +', '+ user.email +' ('+ user.birthday +')</div></div>';
            },
            templateSelection: function(user) {
                if(!user.firstname || 0 === user.firstname.length) return user.text;
                if(!user.lastname || 0 === user.lastname.length) return user.text;
                return user.firstname + ' ' + user.lastname;
            },
            width: '100%'
        });
    });
</script>