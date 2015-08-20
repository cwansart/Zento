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
        $dateTime = Carbon::parse($request->get('date'));
        $time = Carbon::parse($request->get('time'));
        $dateTime->setTime($time->hour, $time->minute, 0);
        $request['start_date'] = $request['holeDay'] ? $request['date'] : $dateTime;
        $request['all_day'] = $request->get('holeDay');
        dd($request);
        $appointment = Appointment::create($request->all());

        return redirect(action('AppointmentController@index'))->with('status', 'Termin "'.$appointment->title.'" wurde hinzugefügt.');
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
