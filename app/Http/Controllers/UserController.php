<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;

use Zento\Http\Requests;
use Zento\Http\Controllers\Controller;
use Zento\User;
use Zento\Group;
use Zento\Location;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::paginate(15);
        $groups = Group::all();
        $groupsArray = array();
        foreach($groups as $group) {
            $groupsArray[$group->id] = $group->name;
        }

        // returns users as JSON if requested by $.getJSON
        return $request->ajax() ? $users : view('users.index')->with('users', $users)->with('groups', $groupsArray);
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
        $validator = Validator::make($request->all(), User::$rules);

        if ($validator->fails()) {
            return redirect(action('UserController@index'))
                ->withErrors($validator)
                ->withInput();
        }

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
            $location = $location->get();
        }

        $user = new User();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email'); // TODO: what'll happen if email is already taken? Perhaps we need to catch an exception here..
        $user->birthday = $request->input('birthday');
        $user->entry_date = $request->input('entry_date');
        $user->location_id = $location->id;
        $user->active = $request->input('active');
        $user->group_id = $request->input('group_id'); // TODO: We need to check if group_id exists

        // we need to check if the password is empty. If so, we just skip the password field so it'll be nulled
        if(empty($request->input('password'))) {
            $user->password = $request->input('password');
        }

        $user->save();
        // TODO: pass a message to the view to inform about success.

        return redirect(action('UserController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return $request->ajax() ? $user : view('users.show')->with('user', $user);
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
