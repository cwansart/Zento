<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 27.07.15
 * Time: 19:54
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Zento\Appointment;

class AppointmentTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('appointments')->delete();

        Appointment::create([
            'title' => 'Training',
            'description' => 'Erwachsenentraining EM',
            'date' => Carbon::now()->setTime(19, 0, 0),
            'end_date' => Carbon::now()->setTime(21, 0, 0),
            'all_day' => false,
            'color' => '#6aec13'
        ]);

        Appointment::create([
            'title' => 'Training',
            'description' => 'Erwachsenentraining Wasser',
            'date' => Carbon::now()->addWeekdays(2)->setTime(19, 0, 0),
            'end_date' => Carbon::now()->addWeekdays(2)->setTime(19, 0, 0),
            'all_day' => true,
            'color' => '#6aec13'
        ]);

        Appointment::create([
            'title' => 'Training',
            'description' => 'Kindertraining',
            'date' => Carbon::now()->addWeekdays(4)->setTime(19, 0, 0),
            'end_date' => Carbon::now()->addWeekdays(4)->setTime(19, 0, 0),
            'all_day' => true,
            'color' => '#ff0000'
        ]);

        Appointment::create([
            'title' => 'Training',
            'date' => Carbon::now()->addWeekdays(-1)->setTime(19, 30, 0),
            'end_date' => Carbon::now()->addWeekdays(-1)->setTime(19, 30, 0),
            'all_day' => true,
            'color' => '#ff0000'
        ]);

        Appointment::create([
            'title' => 'Lehrgang Dänemark',
            'description' => 'Trainingscamp 2015',
            'date' => Carbon::now()->addWeekdays(7)->setTime(8, 0, 0),
            'end_date' => Carbon::now()->addWeekdays(14)->setTime(22, 0, 0),
            'all_day' => false,
            'color' => '#eb9514'
        ]);

        Appointment::create([
            'title' => 'Training',
            'date' => Carbon::now()->addWeekdays(9)->setTime(19, 30, 0),
            'end_date' => Carbon::now()->addWeekdays(9)->setTime(22, 0, 0),
            'all_day' => false,
            'color' => '#6aec13'
        ]);
    }
}