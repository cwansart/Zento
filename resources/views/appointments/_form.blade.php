<div class="form-group">
    {!! Form::label('type', 'Terminart', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('type', array('Allgemein' => 'Allgemein', 'Training' => 'Training', 'Lehrgang' => 'Lehrgang', 'Prüfung' => 'Prüfung'), null, ['class' => 'form-control', 'id' => 'type-select']) !!}
    </div>
</div>

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
    {!! Form::label('end', 'Bis', ['class' => 'col-md-4 control-label']) !!}
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
                {!! Form::checkbox('allDay', 1, $allDayChecked) !!} ganztägig?
            </label>
        </div>
    </div>
</div>

<div id="trainer-section">
    <div class="form-group">
        {!! Form::label('train', 'Trainer', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            @if(isset($trainer) && count($trainer))
                <ul>
                    @foreach($trainer as $train)
                        @if($train->id != Auth::id())
                            <li>{!! $train->firstname !!} {!! $train->lastname !!} ({!! \Zento\Appointment::$priority[$train->pivot->priority] !!})</li>
                        @endif
                    @endforeach
                </ul>
            @else
                <p>Noch kein Trainer!</p>
            @endif
            <div class="checkbox" id="allDay-wrapper">
                <label>
                    {!! Form::checkbox('train', 1, $trainChecked, array('onchange' => 'updateTrain(this)', 'id' => 'train-checkbox')) !!} Training geben?
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('priority', 'Priorität', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::select('priority', array(0 => 'Nicht möglich', 1 => 'Niedrig', 2 => 'Normal', 3 => 'Hoch'), $prioSelect, ['class' => 'form-control', 'id' => 'prio-select']) !!}
        </div>
    </div>

    <div id="reminder-selection">
        <div class="form-group">
            {!! Form::label('reminder', 'Erinnerung', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::select('reminder', array(0 => 'Keine Erinnerung', 12 => '12 Stunden vorher', 24 => '24 Stunden vorher'), $reminderSelect, ['class' => 'form-control', 'id' => 'reminder-select']) !!}
            </div>
        </div>
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
            placeholder: "Hinzufügen...",
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

        $('#type-select').change(function() {
            if(this.value != 'Training')
            {
                $('#trainer-section').addClass('hidden');
            } else {
                $('#trainer-section').removeClass('hidden');
            }
        });

        $(function() {
            updateTrain(document.getElementById('train-checkbox'));
            if($('#type-select option:selected').text() != 'Training')
            {
                $('#trainer-section').addClass('hidden');
            } else {
                $('#trainer-section').removeClass('hidden');
            }
        });
    });

    function updateTrain(element) {
        if(element.checked == true)
        {
            document.getElementById('prio-select').disabled = false;
            document.getElementById('reminder-select').disabled = false;
        } else {
            document.getElementById('prio-select').disabled = true;
            document.getElementById('reminder-select').disabled = true;
        }
    }

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