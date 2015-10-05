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

class AppointmentUserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('appointment_user')->delete();

        $appointment = Appointment::find(1);
        $appointment->users()->attach(User::find(1));
        $appointment->users()->attach(User::find(2));
        $appointment->users()->updateExistingPivot(1, ['priority' => 0]);
        $appointment->users()->updateExistingPivot(2, ['priority' => 1]);
    }
}