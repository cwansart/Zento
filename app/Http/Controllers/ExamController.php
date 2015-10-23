<?php

namespace Zento\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Zento\Http\Requests\ExamRequest;
use Zento\Http\Requests\ExamAddUserRequest;

use Zento\Http\Requests;
use Zento\Http\Controllers\Controller;

use Zento\Location;
use Zento\Exam;
use Zento\Seminar;
use Zento\User;
use Validator;
use Auth;

class ExamController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin', ['only' => ['edit', 'store', 'update', 'destroy', 'destroyResult']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $exams = Exam::getOrdered($request->get('orderBy'))->paginate(15);
        return view('exams.index')->with('exams', $exams)
                ->with('sortBy', $request->get('orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('exams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExamRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExamRequest $request)
    {
        $location = Location::findOrCreate($request->all());
        $request['location_id'] = $location->id;

        Exam::create($request->all());

        return redirect(action('ExamController@index'))->with('status', 'Prüfung wurde hinzugefügt.');
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
        $exam = Exam::findOrFail($id);
        $users = $exam->users;
        return $request->ajax() ? $users :
            view('exams.show')
                ->with('exam', $exam)
                ->with('users', $users)
                ->with('results', Exam::$results);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        return view('exams.edit')
            ->with('exam', $exam);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExamRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExamRequest $request, $id)
    {
        $location = Location::findOrCreate($request->all());
        $request['location_id'] = $location->id;

        $exam = Exam::findOrFail($id);
        $exam->update($request->all());
        return redirect(action('ExamController@index'))
            ->with('status', 'Prüfung vom '.$exam->date.' aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();
        return redirect(action('ExamController@index'))
            ->with('status', 'Prüfung erfolgreich gelöscht!');
    }

    /**
     * Gets users that are not attached to the exam with $examid.
     *
     * @param Request $request
     * @param $examid
     * @return string
     */
    public function getUnregisteredUsers(Request $request, $examid)
    {
        if(!empty($request->get('q'))) {
            $searchterm = $request->get('q');
            $users = User::whereNotIn('id', Exam::find($examid)->users->lists('id'))
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
     * Removes a user from a specific exam.
     *
     * @param $examid
     * @param $userid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeUser($examid, $userid)
    {
        $user = User::findOrFail($userid);
        $exam = Exam::findOrFail($examid);
        $exam->users()->detach($user);
        return redirect(action('ExamController@show', [$examid]))
            ->with('status', 'Benutzer wurde aus Prüfung entfernt!');
    }

    /**
     * Adds a user to a specific exam.
     *
     * @param ExamAddUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addUser(ExamAddUserRequest $request, $id)
    {
        $exam = Exam::findOrFail($id);
        $user = User::findOrFail($request->input('userid'));
        $result = Exam::$results[$request->input('result')];

        $exam->users()->attach($user);
        $exam->users()->updateExistingPivot($user->id, ['result' => $result]);

        return redirect()->action('ExamController@show', $id)->with('status', $user->firstname.' '.$user->lastname.' hinzugefügt');
    }
}
