<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;
use Zento\Http\Requests\AppointmentRequest;

use Carbon\Carbon;
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
        $appointments = Appointment::all();

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
            ->with('appointment', $appointment);
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
}
