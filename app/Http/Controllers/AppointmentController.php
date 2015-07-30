<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use DB;
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
            ->select('title', 'date as start', 'end_date as end', 'all_day as allDay')
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
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $date)
    {
        $appointments = Appointment::where('date', '=', new \DateTime($date))
            ->orWhereNotNull('end_date')
            ->where('date', '<=', new \DateTime($date))
            ->where('end_date', '>=', new \DateTime($date))->get();

        if(Carbon::parse($date)->format('d.m.y') == Carbon::now()->format('d.m.y')) {
            $date = "Heute";
        } elseif(Carbon::parse($date)->format('d.m.y') == Carbon::now()->addDay()->format('d.m.y')) {
            $date = "Morgen";
        } elseif(Carbon::parse($date)->format('d.m.y') == Carbon::now()->addDay(-1)->format('d.m.y')) {
            $date = "Gestern";
        } else {
        $date = 'am '.Carbon::parse($date)->format('d.m.y');
        }

        // returns appointments as JSON if
        return $request->ajax() ? $appointments : view('appointments.show')
            ->with('appointments', $appointments)
            ->with('date', $date);
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
