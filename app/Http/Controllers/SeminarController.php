<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;
use Zento\Http\Requests\SeminarRequest;

use Zento\Http\Requests;
use Zento\Http\Controllers\Controller;
use Zento\Seminar;
use Zento\Group;
use Zento\User;
use Zento\Location;
use Auth;
use DB;
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
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $seminars = Seminar::query();

        if($request->has('q')) {
            $seminars = $seminars->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhereExists(function ($query) use ($request) {
                        $query->select(DB::raw(1))
                            ->from('locations')
                            ->whereRaw('locations.id = seminars.location_id')
                            ->where(function ($query) use ($request) {
                               $query->where('street', 'LIKE', '%' . $request->get('q') . '%')
                                   ->orWhere('housenr', 'LIKE', '%' . $request->get('q') . '%')
                                   ->orWhere('zip', 'LIKE', '%' . $request->get('q') . '%')
                                   ->orWhere('city', 'LIKE', '%' . $request->get('q') . '%')
                                   ->orWhere('country', 'LIKE', '%' . $request->get('q') . '%');
                            });
                    });
            });
        }

        $seminars = $seminars->getOrdered($request->get('orderBy'))->paginate(15);
        return view('seminars.index')->with('seminars', $seminars)
            ->with('sortBy', $request->get('orderBy'))
            ->with('filterSearch', $request->has('q') ? $request->get('q') : '');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('seminars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SeminarRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function show(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        $users = $seminar->users;
        return view('seminars.show')
            ->with('users', $users)
            ->with('seminar', $seminar)
            ->with('groups', Group::groupsArray())
            ->with('sortBy', $request->has('orderBy') ? $request->get('orderBy') : 'firstname:ASC')
            ->with('filterSearch', $request->has('q') ? $request->get('q') : '')
            ->with('filterGroup', $request->has('g') ? $request->get('g') : '-1')
            ->with('filterStatus', $request->has('a') ? $request->get('a') : '-1');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return $this
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
     * @param SeminarRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SeminarRequest $request, $id)
    {
        $location = Location::findOrCreate($request->all());
        $request['location_id'] = $location->id;

        $seminar = Seminar::findOrFail($id);
        $seminar->update($request->all());
        return redirect(action('SeminarController@index'))
            ->with('status', 'Seminar '.$seminar->title.' vom '.$seminar->date.' aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
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
     * @return string
     */
    public function getUnregisteredUsers(Request $request, $seminarid)
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
        $user = User::findOrFail($userid);
        $seminar = Seminar::findOrFail($seminarid);
        $seminar->users()->detach($user);
        return redirect(action('SeminarController@show', [$seminarid]))
            ->with('status', 'Benutzer wurde aus dem Seminar entfernt!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addUser(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        $user = User::findOrFail($request->input('userid'));
        $seminar->users()->attach($user);

        return redirect()->action('SeminarController@show', $id)->with('status', $user->firstname.' '.$user->lastname.' hinzugefügt');
    }
}
