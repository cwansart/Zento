<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;
use Zento\Http\Requests\SeminarRequest;

use Zento\Http\Requests;
use Zento\Http\Controllers\Controller;
use Zento\Seminar;
use Zento\User;
use Zento\Location;
use Auth;
use Validator;

class SeminarController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin', ['only' => ['edit', 'store', 'update', 'destroy', 'removeUser']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $seminars = Seminar::paginate(15);
        return view('seminars.index')->with('seminars', $seminars);
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
    public function store(SeminarRequest $request)
    {
        $location = Location::findOrCreate($request->all());
        $request['location_id'] = $location->id;

        Seminar::create($request->all());

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
        $users = $seminar->users;
        return view('seminars.show')
            ->with('users', $users)
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
        $seminar = Seminar::FindOrFail($id);
        return view('seminars.edit')
            ->with('seminar', $seminar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(SeminarRequest $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->update($request->all());
        return redirect(action('SeminarController@index'))
            ->with('status', 'Seminar '.$seminar->title.' vom '.$seminar->date.' aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->delete();
        return redirect(action('SeminarController@index'))
            ->with('status', 'Seminar erfolgreich gelöscht!');
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

    /**
     * Removes a specific user from a specified seminar.
     *
     * @param $seminarid
     * @param $userid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeUser($seminarid, $userid)
    {
        $user = User::find($userid);
        $seminar = Seminar::find($seminarid);
        $seminar->users()->detach($user);
        return redirect(action('SeminarController@show', [$seminarid]))
            ->with('status', 'Benutzer wurde aus dem Seminar entfernt!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateSeminar(Request $request, $id)
    {
        $seminar = Seminar::find($id);
        $user = User::find($request->input('userid'));
        $seminar->users()->attach($user);

        return redirect()->action('SeminarController@show', $id)->with('status', $user->firstname.' '.$user->lastname.' hinzugefügt');
    }
}
