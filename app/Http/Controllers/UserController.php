<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Hash;
use Validator;
use Zento\Http\Requests;
use Zento\Http\Controllers\Controller;
use Zento\User;
use Zento\Group;
use Zento\Location;
use \Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin', ['only' => ['edit', 'store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $orderBy = $order = null;
        if(!empty($request->get('orderBy')) && strpos($request->get('orderBy'), ':') !== false) {
            list($orderBy, $order) = explode(':', $request->get('orderBy'));
        }
        switch($orderBy) {
            case 'id':
            case 'firstname':
            case 'lastname':
                break;
            default:
                $orderBy = 'id';
                break;
        }
        switch($order) {
            case 'ASC':
            case 'DESC':
                break;
            default:
                $order = 'ASC';
                break;
        }

        $users = User::orderBy($orderBy, $order)->paginate(15);

        // returns users as JSON if requested by $.getJSON
        return $request->ajax() ? $users :
            view('users.index')
                ->with('users', $users)
                ->with('groups', Group::groupsArray())
                ->with('sortBy', $request->get('orderBy'));
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

        $location = Location::findOrCreate($request->all());

        $user = User::create($request->all());
        $user->location_id = $location->id;
        $user->save();

        return redirect(action('UserController@index'))->with('status', 'Benutzer '.$user->firstname.' '.$user->lastname.' wurde hinzugefügt.');
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
        $seminars = $user->seminars;
        $exams = $user->exams;
        return $request->ajax() ? $user : view('users.show')
            ->with('user', $user)
            ->with('seminars', $seminars)
            ->with('exams', $exams);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        // we need to add and adjust some data so it'll be filled in the input fields
        $user['street'] = $user->address->street;
        $user['housenr'] = $user->address->housenr;
        $user['zip'] = $user->address->zip;
        $user['city'] = $user->address->city;

        return view('users.edit')
            ->with('user', $user)
            ->with('groups', Group::groupsArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $rules = User::$rules;

        // Just a little fix when the mail address is the same. Otherwise
        // it'd throw an error saying that the mail address already exists.
        if($request->get('email') == $user->email) {
            $rules['email'] = 'required|email';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(action('UserController@edit', [$id]))
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $location = Location::findOrCreate($data);
        $data['location_id'] = $location->id;
        $user->update($data);

        return redirect(action('UserController@index'))
            ->with('status', 'Profil von '.$user->firstname.' '.$user->lastname.' aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect(action('UserController@index'))
            ->with('status', 'Benutzer erfolgreich gelöscht!');
    }

    public function admins(Request $request)
    {
        $admins = User::where('is_admin', '=', true)->get();
        return view('users.admins')->with('admins', $admins);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Shows the view to change the profile of logged in user
     */
    public function editProfile(Request $request)
    {
        $user = Auth::user();
        return $request->ajax() ? $user :
            view('users.editProfile')
                ->with('user', $user)
                ->with('groups', Group::groupsArray());
    }

    /**
     * Updates the profile
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $rules = User::$editProfileRules;

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(action('UserController@editProfile'))
                ->withErrors($validator)
                ->withInput();
        }

        // check if the passwords match
        if($request->get('password') != $request->get('password2')) {
            return redirect(action('UserController@editProfile'))
                ->withErrors(['password' => 'Die eigegebenen Passwörter stimmen nicht überein!'])
                ->withInput();
        }

        $user = Auth::user();
        $user->email = empty($request->get('email')) ? $user->email : $request->get('email');
        $user->password = $request->get('password');
        $user->save();

        return redirect(action('UserController@editProfile'))
            ->with('status', 'Benutzerdaten erfolgreich aktualisiert!');
    }
}
