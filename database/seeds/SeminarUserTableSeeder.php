<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 24.07.15
 * Time: 21:29
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Zento\Seminar;
use Zento\User;


class SeminarUserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('seminar_user')->delete();

        $users = User::lists('id');
        $seminar = DB::table('seminars')->where('title', '=', 'Jo Lehrgang')->first();

        foreach ($users as $user)
            DB::table('seminar_user')->insert(array('seminar_id' => $seminar->id, 'user_id' => $user));

        $seminar = DB::table('seminars')->where('title', '=', 'Bo Lehrgang')->first();

        foreach ($users as $user)
            DB::table('seminar_user')->insert(array('seminar_id' => $seminar->id, 'user_id' => $user));

        $seminar = DB::table('seminars')->where('title', '=', 'Chi Gong mit Wing Chun')->first();

        foreach ($users as $user)
            DB::table('seminar_user')->insert(array('seminar_id' => $seminar->id, 'user_id' => $user));

        $seminar = DB::table('seminars')->where('title', '=', 'Dänemark Trainingscamp 2011')->first();

        foreach ($users as $user)
            if ($user < 2)
            DB::table('seminar_user')->insert(array('seminar_id' => $seminar->id, 'user_id' => $user));

        $seminar = DB::table('seminars')->where('title', '=', 'Dänemark Trainingscamp 2012')->first();

        foreach ($users as $user)
            if ($user < 3)
                DB::table('seminar_user')->insert(array('seminar_id' => $seminar->id, 'user_id' => $user));

        $seminar = DB::table('seminars')->where('title', '=', 'Dänemark Trainingscamp 2013')->first();

        foreach ($users as $user)
            if ($user < 4)
                DB::table('seminar_user')->insert(array('seminar_id' => $seminar->id, 'user_id' => $user));

        $seminar = DB::table('seminars')->where('title', '=', 'Dänemark Trainingscamp 2014')->first();

        foreach ($users as $user)
            if ($user < 5)
                DB::table('seminar_user')->insert(array('seminar_id' => $seminar->id, 'user_id' => $user));


    }
}
