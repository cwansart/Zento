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
            'date' => Carbon::now(),
            'location_id' => 5
        ]);

        Appointment::create([
            'title' => 'Training',
            'date' => Carbon::now()->addWeekdays(2),
            'location_id' => 5
        ]);

        Appointment::create([
            'title' => 'Training',
            'date' => Carbon::now()->addWeekdays(4),
            'location_id' => 5
        ]);

        Appointment::create([
            'title' => 'Training',
            'date' => Carbon::now()->addWeekdays(-1),
            'location_id' => 5
        ]);

        Appointment::create([
            'title' => 'Lehrgang Dänemark',
            'date' => Carbon::now()->addWeekdays(7),
            'end_date' => Carbon::now()->addWeekdays(14),
            'location_id' => 5
        ]);
    }
}