<?php

namespace Zento\Http\Controllers;

use Illuminate\Http\Request;

use Zento\Http\Requests;
use Zento\Http\Controllers\Controller;
use Zento\User;
use PDF;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //return view('lists.index');

        $sortBy = $request->has('orderBy') ? $request->orderBy : 'user_id:ASC';
        $users = User::getOrdered($sortBy)->paginate(15);

        return view('lists.create')
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
        $sortBy = $request->has('orderBy') ? $request->orderBy : 'user_id:ASC';
        $users = User::getOrdered($sortBy)->paginate(15);

        return view('lists.create')
            ->with('sortBy', 'lastname:ASC')
            ->with('users', $users);
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

    /**
     * Generiert eine Liste als PDF und gibt die entsprechende ID zurück
     * @param Request $request
     * @return Listen-ID
     */
    public function generateList(Request $request) {
        $currentColumns = $request->get('currentColumns');
        $emptyColumns = $request->get('emptyColumns');
        $orderBy = $request->get('orderBy');
        $emptyColumnsId = 0;
        $shaId = sha1(implode(',', $currentColumns));

        // Tabellen-CSS
        $cellWidth = (1.0/count($currentColumns)) * 100;
        $css = <<<EOF
<style>
body {
    background-image: url(data:image/png;base64,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);
    background-repeat: no-repeat;
    background-position: right top;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}

td, th {
    width: $cellWidth %;
    padding: 3pt;
}

th {
    text-align: left;
}
</style>
EOF;

        // Tabellenkopf erstellen
        $tableHead = "<thead><tr>";
        foreach($currentColumns as $column) {
            switch($column) {
                case 'firstname':
                    $tableHead .= '<th>Vorname</th>';
                    break;
                case 'lastname':
                    $tableHead .= '<th>Nachname</th>';
                    break;
                case 'birthday':
                    $tableHead .= '<th>Geburtstag</th>';
                    break;
                case 'entry_date':
                    $tableHead .= '<th>Eintrittsdatum</th>';
                    break;
                case 'address':
                    $tableHead .= '<th>Adresse</th>';
                    break;
                case 'group':
                    $tableHead .= '<th>Gruppe</th>';
                    break;
                default: //empty
                    $tableHead .= '<th>' . $emptyColumns[$emptyColumnsId++] . '</th>';
            }
        }
        $tableHead .= '</tr></thead>';

        // Tabellenkörper erstellen
        $users = User::getOrdered($orderBy)->get();
        // Tabellenkopf erstellen
        $tableBody = "<tbody>";
        foreach($users as $user) {
            $tableBody .= '<tr>';
            foreach ($currentColumns as $column) {
                $tableBody .= '<td>';
                switch ($column) {
                    case 'firstname':
                        $tableBody .= $user->firstname;
                        break;
                    case 'lastname':
                        $tableBody .= $user->lastname;
                        break;
                    case 'birthday':
                        $tableBody .= $user->birthday;
                        break;
                    case 'entry_date':
                        $tableBody .= $user->entry_date;
                        break;
                    case 'address':
                        $tableBody .= $user->addressStr();
                        break;
                    case 'group':
                        $tableBody .= $user->group->name;
                        break;
                    default: //empty
                }
                $tableBody .= '</td>';
            }
            $tableBody .= '</tr>';
        }
        $tableBody .= "</tbody>";

        // Tabelle zusammenfügen
        $table = $request->get('listtitle') != null ? '<h1>'.$request->get('listtitle').'</h1>' : '<h1>&nbsp;</h1>';
        $table .= $css.'<table>'.$tableHead.$tableBody.'</table>';

        // PDF erzeugen
        return PDF::loadHTML($table)->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->download();

        //return $shaId;
    }
}
