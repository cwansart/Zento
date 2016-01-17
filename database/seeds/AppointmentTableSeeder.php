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
            'type' => 'Training',
            'title' => 'Training',
            'description' => 'Erwachsenentraining EM',
            'start' => Carbon::now()->setTime(19, 0, 0),
            'end' => Carbon::now()->setTime(21, 0, 0),
            'allDay' => false
        ]);

        Appointment::create([
            'type' => 'Prüfung',
            'title' => 'Prüfung',
            'description' => 'Erwachsenentraining EM',
            'start' => Carbon::now()->setTime(21, 0, 0),
            'end' => Carbon::now()->setTime(22, 30, 0),
            'allDay' => false
        ]);

        Appointment::create([
            'type' => 'Allgemein',
            'title' => 'Abschlussbesprechung',
            'description' => 'Prüfungsabschlussbesprechung',
            'start' => Carbon::now()->setTime(22, 30, 0),
            'end' => Carbon::now()->setTime(22, 35, 0),
            'allDay' => false
        ]);

        Appointment::create([
            'type' => 'Training',
            'title' => 'Training',
            'description' => 'Erwachsenentraining Wasser',
            'start' => Carbon::now()->addWeekdays(2)->setTime(19, 0, 0),
            'end' => Carbon::now()->addWeekdays(2)->setTime(19, 0, 0),
            'allDay' => true
        ]);

        Appointment::create([
            'type' => 'Training',
            'title' => 'Training',
            'description' => 'Kindertraining',
            'start' => Carbon::now()->addWeekdays(4)->setTime(19, 0, 0),
            'end' => Carbon::now()->addWeekdays(4)->setTime(19, 0, 0),
            'allDay' => true
        ]);

        Appointment::create([
            'type' => 'Training',
            'title' => 'Training',
            'start' => Carbon::now()->addWeekdays(-1)->setTime(19, 30, 0),
            'end' => Carbon::now()->addWeekdays(-1)->setTime(19, 30, 0),
            'allDay' => true
        ]);

        Appointment::create([
            'type' => 'Lehrgang',
            'title' => 'Lehrgang Dänemark',
            'description' => 'Trainingscamp 2015',
            'start' => Carbon::now()->addWeekdays(7)->setTime(8, 0, 0),
            'end' => Carbon::now()->addWeekdays(14)->setTime(22, 0, 0),
            'allDay' => false
        ]);

        Appointment::create([
            'type' => 'Training',
            'title' => 'Training',
            'start' => Carbon::now()->addWeekdays(9)->setTime(19, 30, 0),
            'end' => Carbon::now()->addWeekdays(9)->setTime(22, 0, 0),
            'allDay' => false
        ]);
    }
}