<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Appointment::$rules);

        if ($validator->fails()) {
            return redirect(action('AppointmentController@index'))
                ->withErrors($validator)
                ->withInput();
        }

        $request['all_day'] = $request->has('holeDay');

        $request['date'] = Carbon::createFromFormat('d.m.Y', $request->get('date'));
        $request['end_date'] = Carbon::createFromFormat('d.m.Y', $request->get('end_date'));

        if(!$request->has('holeDay')) {
            $time = Carbon::parse($request->get('time'));
            $endTime = Carbon::parse($request->get('end_time'));
            $request['date']->setTime($time->hour, $time->minute);
            $request['end_date']->setTime($endTime->hour, $endTime->minute);
        }

        $appointment = Appointment::create($request->all());

        return redirect(action('AppointmentController@index'))->with('status', 'Termin <i>'.$appointment->title.'</i> wurde hinzugefügt.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $event = Appointment::where('id', '=', $id)->first();
        // returns appointments as JSON if
        return $request->ajax() ? $event : view('appointments.show')
            ->with('event', $event);
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
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
