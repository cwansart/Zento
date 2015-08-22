<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;
use Zento\Http\Requests\AppointmentRequest;

use Carbon\Carbon;
use DB;
use Validator;
use Zento\Appointment;
use Zento\Http\Requests;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $appointments = DB::table('appointments')
            ->select('id', 'title', 'description', 'date as start', 'end_date as end', 'all_day as allDay')
            ->get();

        // fullcalendar needs the date in the ISO8601 format, so we'll fix this here.
        foreach($appointments as $appointment) {
            $appointment->start = Carbon::parse($appointment->start)->toIso8601String();
            $appointment->end = Carbon::parse($appointment->end)->toIso8601String();
        }

        // returns appointments as JSON if
        return $request->ajax() ? $appointments : view('appointments.index')->with('appointments', $appointments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(AppointmentRequest $request)
    {
        $request['all_day'] = $request->has('holeDay');

        // If allDay/wholeDay is checked then end and start date are the same!
        if($request->has('wholeDay')) {
            $request['date'] = $request['end_date'] = Carbon::createFromFormat('d.m.Y', $request->get('date'));
        } else {
            $request['date'] = Carbon::createFromFormat('d.m.Y H:i', $request->get('date'));
            $request['end_date'] = Carbon::createFromFormat('d.m.Y H:i', $request->get('end_date'));
        }

        $appointment = Appointment::create($request->all());

        return redirect(action('AppointmentController@index'))->with('status', 'Termin „'.$appointment->title.'” wurde hinzugefügt.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(AppointmentRequest $request, $id)
    {
        $request['all_day'] = $request->has('wholeDay');

        // If allDay/wholeDay is checked then end and start date are the same!
        if($request->has('wholeDay')) {
            $request['date'] = $request['end_date'] = Carbon::createFromFormat('d.m.Y', $request->get('date'));
        } else {
            $request['date'] = Carbon::createFromFormat('d.m.Y H:i', $request->get('date'));
            $request['end_date'] = Carbon::createFromFormat('d.m.Y H:i', $request->get('end_date'));
        }

        $appointment= Appointment::findOrFail($id);
        $appointment->update($request->all());

        return redirect(action('AppointmentController@index'))->with('status', 'Termin „'.$appointment->title.'” wurde bearbeitet.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return redirect(action('AppointmentController@index'))
            ->with('status', 'Termin erfolgreich gelöscht!');
    }
}
