<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;

use Zento\Http\Requests;
use Zento\Http\Controllers\Controller;
use Zento\Seminar;
use Zento\User;
use Auth;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $seminars = Seminar::paginate(15);

        // returns seminars as JSON if
        return $request->ajax() ? $seminars : view('seminars.index')->with('seminars', $seminars);
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
        if(!Auth::user()->is_admin) {
            return redirect('seminars.index');
        }

        $validator = Validator::make($request->all(), Seminar::$rules);
        //dd($request);

        if ($validator->fails()) {
            return redirect(action('ExamController@index'))
                ->withErrors($validator)
                ->withInput();
        }

        // TODO: extract this block to the Location model
        // check if given location exists; use or create otherwise.
        $location = Location::where('street', '=', $request->input('street'))
            ->where('housenr', '=', $request->input('housenr'))
            ->where('zip', '=', $request->input('zip'))
            ->where('city', '=', $request->input('city'))
            ->where('country', '=', $request->input('country'));
        if(!$location->exists()) {
            // create location if it doesn't exist
            $location = Location::create([
                // do we really need a name in a location? We'll leave it blank for now...
                //'name' => $request->input('firstname').' '.$request->input('lastname'),
                'street' => $request->input('street'),
                'housenr' => $request->input('housenr'),
                'zip' => $request->input('zip'),
                'city' => $request->input('city'),
                'country' => $request->input('country')
            ]);
        } else {
            // we need to call get() otherwise we'd have an query object
            $location = $location->first();
        }

        $seminar = new Seminar();
        $seminar->date = \Carbon\Carbon::createFromFormat('d.m.Y', $request->input('date')); // TODO: We should find a more localized friendly version; this way only the German date format works.
        $seminar->title = $request->input('title');
        $seminar->location_id = $location->id;
        $seminar->save();

        // TODO: add success information to view
        return redirect(action('SeminarController@index'))->with('status', 'Seminar wurde hinzugefügt.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $seminar = Seminar::find($id);
        $seminarUsers = $seminar->users;
        $title = Seminar::find($id)->title;
        return $request->ajax() ? $seminarUsers : view('seminars.show')
            ->with('seminarUsers', $seminarUsers)
            ->with('title', $title)
            ->with('seminar', $seminar);
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
    public function update(Request $request, $id)
    {
        if(!Auth::user()->is_admin) {
            return redirect('seminars.index');
        }

        $seminar = Seminar::find($id);
        $user = User::find($request->input('userid'));

        $seminar->users()->attach($user);

        return redirect()->action('SeminarController@show', $id)->with('status', $user->firstname.' '.$user->lastname.' hinzugefügt');
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


    /**
     * Gets users that are not attached to the seminar with $seminarid.
     *
     * @param Request $request
     * @param $seminarid
     * @return mixed
     */
    public function getUnregisterdUsers(Request $request, $seminarid)
    {
        if(!empty($request->get('q'))) {
            $searchterm = $request->get('q');
            $users = User::whereNotIn('id', Seminar::find($seminarid)->users->lists('id'))
                ->where(function($query) use($searchterm) {
                    $query->where('firstname', 'LIKE', '%'.$searchterm.'%')
                        ->orWhere('lastname', 'LIKE', '%'.$searchterm.'%')
                        ->orWhere('email', 'LIKE', '%'.$searchterm.'%');
                })->get();
            return $users;
        }


        return '';
    }
}
