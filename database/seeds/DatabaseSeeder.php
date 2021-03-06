<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UserTableSeeder');
        $this->call('LocationTableSeeder');
        $this->call('GroupTableSeeder');
        $this->call('ExamTableSeeder');
        $this->call('SeminarTableSeeder');
        $this->call('ExamUserTableSeeder');
        $this->call('SeminarUserTableSeeder');
        $this->call('AppointmentTableSeeder');
        $this->call('AppointmentUserTableSeeder');
        $this->command->info('Seeding complete!');

        Model::reguard();
    }
}
