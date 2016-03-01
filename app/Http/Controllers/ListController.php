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
        return view('lists.index');
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
        $emptyColumnsId = 0;
        $shaId = sha1(implode(',', $currentColumns));

        // Tabellen-CSS
        $cellWidth = (1.0/count($currentColumns)) * 100;
        $css = <<<EOF
<style>
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
        $users = User::all();
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
        $table = $css.'<table>'.$tableHead.$tableBody.'</table>';

        // PDF erzeugen
        return PDF::loadHTML($table)->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->download();

        //return $shaId;
    }
}
