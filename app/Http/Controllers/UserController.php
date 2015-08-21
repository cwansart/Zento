<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;
use Zento\Http\Requests\UserRequest;
use Zento\Http\Requests\UpdateProfileRequest;

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
        return view('users.create')
            ->with('groups', Group::groupsArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $location = Location::findOrCreate($request->all());
        $request['location_id'] = $location->id;
        $user = User::create($request->all());

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
        $user = User::findOrFail($id);
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
        $user = User::findOrFail($id);

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
    public function update(UserRequest $request, $id)
    {
        $location = Location::findOrCreate($request->all());
        $request['location_id'] = $location->id;
        $user = User::findOrFail($id);
        $user->update($request->all());

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
        if(Auth::user()->id == $id) {
            return redirect(action('UserController@index'))
                ->withErrors('Das eigene Benutzerkonto kann nicht gelöscht werden!');
        }

        $user = User::findOrFail($id);
        $user->delete();
        return redirect(action('UserController@index'))
            ->with('status', 'Benutzer erfolgreich gelöscht!');
    }

    /**
     * Returns the view for edit profile dialog.
     *
     * @param Request $request
     * @return $this
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
     * Updates the profile.
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $request['email'] = empty($request->get('email')) ? $user->email : $request->get('email');
        $request['password'] = empty($request->get('password')) ? $user->password : $request->get('password');
        $user->update($request->all());

        return redirect(action('UserController@editProfile'))
            ->with('status', 'Benutzerdaten erfolgreich aktualisiert!');
    }

    /**
     * Shows the change password dialog for a specific id.
     *
     * @param $id
     * @return $this
     */
    public function changePassword($id)
    {
        $user = User::findOrFail($id);
        return view('users.changePassword')
            ->with('user', $user);
    }

    /**
     * Updates the given password of a specific user.
     *
     * @param UpdateProfileRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UpdateProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);

        // To ensure that nobody passes an email as well (since we're using an
        // UpdateProfileRequest) we'll pass an array solely with the password.
        $user->update(['password' => $request['password']]);

        return redirect(action('UserController@index'))
            ->with('status', 'Password für '.$user->firstname.' '.$user->lastname.' gesetzt.'.$request['password']);
    }
}
