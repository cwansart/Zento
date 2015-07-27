<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;

use Zento\ExamResult;
use Zento\Http\Requests;
use Zento\Http\Controllers\Controller;

use Zento\Location;
use Zento\Exam;
use Zento\User;
use Validator;

class ExamController extends Controller
{
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

        $exam = new Exam();
        $exam->date = \Carbon\Carbon::createFromFormat('d.m.Y', $request->input('date')); // TODO: We should find a more localized friendly version; this way only the German date format works.
        $exam->location_id = $location->id;
        $exam->save();

        // TODO: add success information to view
        return redirect(action('ExamController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $results = ExamResult::where('exam_id', '=', $id)->get();
        $users = User::all();
        return $request->ajax() ? $results : view('exams.show')->with('results', $results)->with('users', $users);
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
