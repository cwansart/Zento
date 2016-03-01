<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Zento\Http\Requests\AppointmentRequest;

use Carbon\Carbon;
use Zento\Appointment;
use Zento\Http\Requests;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Zento\User;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // Check for given month and year, default is current month and year
        $month = !is_null($request->get('month')) ? $request->get('month') : date('n');
        $year = !is_null($request->get('year')) ? $request->get('year') : date('Y');

        $start_date = Carbon::create($year, $month, 1)->addDay(-7)->format('Y-m-d');
        $end_date = Carbon::create($year, $month, 31)->addDay(7)->format('Y-m-d');

        $results = \DB::select( \DB::raw("SELECT * FROM appointments WHERE (start BETWEEN '$start_date' AND '$end_date') OR (end BETWEEN '$start_date' AND '$end_date') ORDER BY start ASC"));
        $appointments_raw = [];
        foreach ($results as $result)
        {
            $start_new = Carbon::createFromFormat('Y-m-d H:i:s', $result->start);
            $start = Carbon::createFromFormat('Y-m-d H:i:s', $result->start);
            $end = Carbon::createFromFormat('Y-m-d H:i:s', $result->end);
            do
            {
                if($start->format('d.m.Y') == $end->format('d.m.Y'))
                {
                    $class = 'zc-event';
                }
                elseif($start_new->eq($start))
                {
                    $class = 'zc-event-left';
                }
                elseif($start_new->format('d.m.Y') == $end->format('d.m.Y'))
                {
                    $class = 'zc-event-right';
                }
                else
                {
                    $class = 'zc-event-middle';
                }

                $trainer = '';
                if($result->type == 'Training')
                {
                    $class = $class.' zc-event-training';

                    if(!count(\DB::select( \DB::raw("SELECT * FROM appointment_user WHERE appointment_id = '$result->id' AND priority > '0'"))))
                    {
                        $trainer = 'glyphicon glyphicon-question-sign zc-red';
                    }
                }
                elseif($result->type == 'Lehrgang')
                {
                    $class = $class.' zc-event-seminar';
                }
                elseif($result->type == 'Prüfung')
                {
                    $class = $class.' zc-event-exam';
                }

                $appointments_raw[$start_new->format('d.m.Y')][] = [
                    'id' => $result->id,
                    'title' => $result->title,
                    'class' => $class,
                    'trainer' => $trainer
                ];
                $start_new->addDay(1);
            }
            while($start_new->lte($end));
        }

        // Get birthdays of month
        $results = \DB::select( \DB::raw("SELECT * FROM users WHERE (MONTH(birthday) = '$month') OR (MONTH(birthday) = '$month' - 1) OR (MONTH(birthday) = '$month' + 1)"));
        $birthdays_raw = [];
        foreach ($results as $result)
        {
            $birthdays_raw[Carbon::createFromFormat('Y-m-d', $result->birthday)->format('d.m')][] = [
                'id' => $result->id,
                'name' => $result->firstname." ".$result->lastname,
                'year' => intval(Carbon::createFromFormat('Y-m-d', $result->birthday)->format('Y'))
            ];
        }
        // Get days of month
        $total_days = date('t', mktime(0, 0, 0, $month, 1, $year));

        // First day of month on correct weekday
        $day_offset = date('w', mktime(0, 0, 0, $month, (1-1), $year));

        $calendar_days = [];
        for($i = 0; $i < (($total_days + $day_offset) + (7 - (($total_days + $day_offset) % 7))); $i++)
        {
            if($i < $day_offset)
            {
                $date = Carbon::create($year, $month, 1)->addDay($i - $day_offset);
                $day = [
                    'num' => $date->format('j'),
                    'class' => 'zc-day zc-other-month',
                    'data-date' => $date->format('d.m.Y')
                ];
            }
            elseif ($i < $total_days + $day_offset)
            {
                $date = Carbon::create($year, $month, $i - $day_offset + 1);
                $day = [
                    'num' => $date->format('j'),
                    'class' => 'zc-day',
                    'data-date' => $date->format('d.m.Y')
                ];
            }
            else
            {
                $date = Carbon::create($year, $month, $total_days)
                    ->addDay($i - ($total_days + $day_offset) + 1);
                $day = [
                    'num' => $date->format('j'),
                    'class' => 'zc-day zc-other-month',
                    'data-date' => $date->format('d.m.Y')
                ];
            }

            if(array_key_exists($date->format('d.m.Y'), $appointments_raw))
            {
                $day['appointments'] = $appointments_raw[$date->format('d.m.Y')];
            }
            else
            {
                $day['appointments'] = [];
            }

            if(array_key_exists($date->format('d.m'), $birthdays_raw))
            {
                $day['birthdays'] = $birthdays_raw[$date->format('d.m')];
            }
            else
            {
                $day['birthdays'] = [];
            }

            $day['year'] = intval($date->format('Y'));
            $calendar_days[$i] = $day;
            if($calendar_days[$i]['data-date'] == Carbon::now()->format('d.m.Y')) {
                $calendar_days[$i]['class'] = $calendar_days[$i]['class'] . ' zc-today';
            }
        }

        // returns appointments as JSON if
        return $request->ajax() ? $appointments_raw : view('appointments.index')
            ->with('calendar_days', $calendar_days)
            ->with('month', $month)
            ->with('year', $year)
            ->with('trainChecked', false)
            ->with('prioSelect', 0)
            ->with('reminderSelect', 0);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AppointmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AppointmentRequest $request)
    {
        // If allDay is checked then end and start date are the same!
        if($request->has('allDay')) {
            $request['start'] = Carbon::createFromFormat('d.m.Y', $request->get('start'));
            $request['end'] = Carbon::createFromFormat('d.m.Y', $request->get('end'));
        } else {
            $request['start'] = Carbon::createFromFormat('d.m.Y H:i', $request->get('start'));
            $request['end'] = Carbon::createFromFormat('d.m.Y H:i', $request->get('end'));
        }

        $appointment = Appointment::create($request->all());

        // If train is checked add the user to the trainer
        if($request->has('train')) {
            $appointment->trainer()->attach(Auth::id());
            $appointment->trainer()->updateExistingPivot(Auth::id(), ['priority' => $request->get('priority')]);
            $appointment->trainer()->updateExistingPivot(Auth::id(), ['reminder' => $request->get('reminder')]);
        }

        return redirect(action('AppointmentController@index'))->with('status', 'Termin „'.$appointment->title.'” wurde hinzugefügt.');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function show(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        return $request->ajax() ?
            $appointment :
            view('appointments.show')
            ->with('appointment', $appointment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('appointments.edit')
            ->with('appointment', $appointment)
            ->with('trainer', $appointment->trainer)
            ->with('trainChecked', $appointment->trainer->contains(Auth::id()))
            ->with('prioSelect', $appointment->trainer->contains(Auth::id()) ? $appointment->trainer->find(Auth::id())->pivot->priority : 0)
            ->with('reminderSelect', $appointment->trainer->contains(Auth::id()) ? $appointment->trainer->find(Auth::id())->pivot->reminder : 0);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AppointmentRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AppointmentRequest $request, $id)
    {
        // If allDay is checked then end and start date are the same!
        if($request->has('allDay')) {
            $request['start'] = Carbon::createFromFormat('d.m.Y', $request->get('start'));
            $request['end'] = Carbon::createFromFormat('d.m.Y', $request->get('end'));
        } else {
            $request['start'] = Carbon::createFromFormat('d.m.Y H:i', $request->get('start'));
            $request['end'] = Carbon::createFromFormat('d.m.Y H:i', $request->get('end'));
        }

        $appointment= Appointment::findOrFail($id);
        $appointment->update($request->all());

        // If train is checked add the user to the trainer
        if($request->has('train')) {
            if(!$appointment->trainer->contains(Auth::id()))
                $appointment->trainer()->attach(Auth::id());
            $appointment->trainer()->updateExistingPivot(Auth::id(), ['priority' => $request->get('priority')]);
            $appointment->trainer()->updateExistingPivot(Auth::id(), ['reminder' => $request->get('reminder')]);
        } else {
            if($appointment->trainer->contains(Auth::id()))
            {
                $appointment->trainer()->detach(Auth::id());
            }
        }

        return redirect(action('AppointmentController@index'))->with('status', 'Termin „'.$appointment->title.'” wurde bearbeitet.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return redirect(action('AppointmentController@index'))
            ->with('status', 'Termin erfolgreich gelöscht!');
    }

    /**
     * Return all trainer to one specific appointment.
     *
     * @param $id
     * @return $appointment->trainer
     */
    public function getTrainer($id)
    {
        $appointment = Appointment::findOrFail($id);
        return $appointment->trainer;
    }

    /**
     * Notify all trainer on appointments without a trainer
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function notifyTrainer()
    {
        $dateTime = Carbon::now()->toDateTimeString();
        $appointments = \DB::select( \DB::raw("SELECT * FROM appointments WHERE appointments.type = 'Training' && appointments.start >= '$dateTime' AND appointments.id NOT IN (SELECT appointment_id FROM appointment_user WHERE priority > 0);"));
        $appointments_prio = \DB::select( \DB::raw("SELECT * FROM appointments WHERE appointments.type = 'Training' && appointments.start >= '$dateTime' AND appointments.id NOT IN (SELECT appointment_id FROM appointment_user WHERE priority > 1) AND appointments.id IN (SELECT appointment_id FROM appointment_user WHERE priority = 1);"));

        if(!count($appointments) && !count($appointments_prio))
        {
            return redirect(action('AppointmentController@index'))
                ->with('status', 'Keine Termine ohne Trainer');
        }
        $users = User::where('id', '!=', Auth::id())
            ->whereNotNull('password')
            ->where('password', '!=', '0') // TODO: Remove this line! Seeder creates users with "0" instead of null
            ->get();

        $to = [];
        foreach($users as $user)
        {
            $to[] = $user->email;
        }

        if(!count($to))
        {
            return redirect(action('AppointmentController@index'))
                ->with('status', 'Keine weiteren Trainer vorhanden!');
        }

        $sender = User::where('id', '=', Auth::id())->first();

        $errors = [];

        $data = array(
            'appointments' => $appointments,
            'appointments_prio' => $appointments_prio,
            'sender' => $sender
        );

        try
        {
            Mail::send('emails.notify', $data, function($message) use($to, $sender)
            {
                $message->from('notify@Zento.dev', 'Zento');
                $message->to($to)->subject('Offene Termine in Zento');
                $message->replyTo($sender->email);
            });
        } catch (Exception $e) {
            $errors[] = $e;
        }

        return redirect(action('AppointmentController@index'))
            ->with('status', 'Benachrichtigung gesendet');
    }
}
