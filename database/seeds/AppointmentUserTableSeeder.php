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
use Zento\User;

class AppointmentUserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('appointment_user')->delete();

        $appointment = Appointment::find(1);
        $appointment->trainer()->attach(User::find(1));
        $appointment->trainer()->attach(User::find(2));
        $appointment->trainer()->attach(User::find(3));
        $appointment->trainer()->updateExistingPivot(1, ['priority' => 0]);
        $appointment->trainer()->updateExistingPivot(2, ['priority' => 1]);
        $appointment->trainer()->updateExistingPivot(3, ['priority' => 2]);

        $appointment = Appointment::find(4);
        $appointment->trainer()->attach(User::find(1));
        $appointment->trainer()->updateExistingPivot(1, ['priority' => 0]);

        $appointment = Appointment::find(8);
        $appointment->trainer()->attach(User::find(1));
        $appointment->trainer()->updateExistingPivot(1, ['priority' => 1]);
    }
}