<?php

namespace Zento\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

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
     * @return Response
     */
    public function index(Request $request)
    {
        $exams = Exam::paginate(15);
        return $request->ajax() ? $exams : view('exams.index')->with('exams', $exams);
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
        $validator = Validator::make($request->all(), Exam::$rules);
        //dd($request);

        if ($validator->fails()) {
            return redirect(action('ExamController@index'))
                ->withErrors($validator)
                ->withInput();
        }

        $location = Location::findOrCreate($request->all());

        $exam = new Exam();
        $exam->date = $request->input('date');
        $exam->location_id = $location->id;
        $exam->save();

        // TODO: add success information to view
        return redirect(action('ExamController@index'))->with('status', 'Prüfung wurde hinzugefügt.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $exam = Exam::find($id);
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
     * @param  int  $id
     * @return Response
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
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Exam::$rules);

        if ($validator->fails()) {
            return redirect(action('ExamController@edit', $id))
                ->withErrors($validator)
                ->withInput();
        }

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
     * @param  int  $id
     * @return Response
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
     * @return mixed
     */
    public function getUnregisterdUsers(Request $request, $examid)
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

    public function destroyResult($examid, $userid)
    {
        $user = User::find($userid);
        $exam = Exam::find($examid);
        $exam->users()->detach($user);
        return redirect(action('ExamController@show', [$examid]))
            ->with('status', 'Benutzer wurde aus Prüfung entfernt!');
    }

    public function updateExam(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Exam::$updateRules);

        if ($validator->fails()) {
            return redirect(action('ExamController@show', $id))
                ->withErrors($validator)
                ->withInput();
        }

        $exam = Exam::find($id);
        $user = User::find($request->input('userid'));
        $result = Exam::$results[$request->input('result')];

        $exam->users()->attach($user);
        $exam->users()->updateExistingPivot($user->id, ['result' => $result]);

        return redirect()->action('ExamController@show', $id)->with('status', $user->firstname.' '.$user->lastname.' hinzugefügt');
    }
}
