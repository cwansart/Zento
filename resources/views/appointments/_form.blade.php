<div class="form-group">
    {!! Form::label('title', 'Titel', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('text', 'title', null, ['class' => 'form-control', 'placeholder' => 'Titel', 'required']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'Beschreibung', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('text', 'description', null, ['class' => 'form-control', 'placeholder' => 'Beschreibung']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('start', 'Von', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <div class="input-group date picker" id="start-picker">
            {!! Form::input('text', 'start', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y')]) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('start', 'Bis', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <div class="input-group date picker" id="end-picker">
            {!! Form::input('text', 'end', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y')]) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
</div>


<div class="form-group">
    <div class="col-md-4"></div>

    <div class="col-md-6">
        <div class="checkbox" id="allDay-wrapper">
            <label>
                {!! Form::checkbox('allDay') !!} ganztägig?
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('start', 'Trainer', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select class="form-control select2" id="user_id" name="user_id">
            @if(isset($appointment) && isset($appointment->user_id))
                <option value="{!! $appointment->trainer->id !!}">{!! $appointment->trainer->firstname !!} {!! $appointment->trainer->lastname !!}</option>
            @else
                <option value="-1">Trainer hinzufügen...</option>
            @endif
        </select>
    </div>
</div>

<script>
    $(function() {
        // Initialize the DateTimePicker.
        $('.picker').datetimepicker({
            language: 'de',
            pickTime: true,
            format: 'DD.MM.YYYY HH:mm'
        });

        // Handles the on change event of the allDay checkbox.
        $('#allDay-wrapper :checkbox').on('change', function() {
            if($(this).is(":checked")) {
                changePickerFormat('DD.MM.YYYY');
            } else {
                changePickerFormat('DD.MM.YYYY HH:mm');
            }
        });

        // Add the trainer selection
        $('.select2').select2({
            width: '100%',
            language: 'de',
            ajax: {
                url: '{!! action('UserController@index') !!}',
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
                        results: data.data
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
    });

    /**
     * Changes the DateTimePicker format and updates the current dates.
     *
     * @param format
     */
    function changePickerFormat(format)
    {
        $('#start-picker').data().DateTimePicker.format = format;
        $('#end-picker').data().DateTimePicker.format = format;
        $('#start-picker').data().DateTimePicker.setDate($('#start-picker').data().DateTimePicker.getDate());
        $('#end-picker').data().DateTimePicker.setDate($('#end-picker').data().DateTimePicker.getDate());
    }
</script>