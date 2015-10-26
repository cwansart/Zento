<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;

use Zento\Http\Requests;
use Zento\Http\Controllers\Controller;
use Zento\User;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $sortBy = $request->has('orderBy') ? $request->orderBy : 'user_id:ASC';
        $users = User::getOrdered($sortBy)->paginate(5);

        return view('lists.index')
            ->with('sortBy', 'lastname:ASC')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $select = "";
        $order = $request->get('firstnameOrder').",".$request->get('lastnameOrder');
        if($request->has('firstname')) {
            $select = $select."FIRSTNAME";
        }
        if($request->has('lastname')) {
            if (!empty($select))
            {
                $select = $select.",";
            }
            $select = $select."LASTNAME";
        }
        if($request->has('email')) {
            if (!empty($select))
            {
                $select = $select.",";
            }
            $select = $select."EMAIL";
        }

        $content = DB::table('users')
            ->select(DB::raw($select." ORDER BY ".$order));
        dd($content);
        return view('lists.create');
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
    public function show($id)
    {
        //
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
