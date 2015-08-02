<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14.07.15
 * Time: 16:58
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Zento\User;


class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'firstname' => 'Markus',
            'lastname' => 'Mustermann',
            'email' => 'markus@mustermann.de',
            'password' => Hash::make('1234'),
            'birthday' => Carbon::createFromDate(1990,1,1),
            'entry_date' => Carbon::createFromDate(2000,1,1),
            'location_id' => 1,
            'active' => true,
            'is_admin' => true,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Martina',
            'lastname' => 'Mustermann',
            'email' => 'martina@mustermann.de',
            'password' => Hash::make('passwort'),
            'birthday' => Carbon::createFromDate(1992,1,1),
            'entry_date' => Carbon::createFromDate(2004,1,1),
            'location_id' => 1,
            'active' => true,
            'is_admin' => false,
            'group_id' => 2,
        ]);

        User::create([
            'firstname' => 'Arnold',
            'lastname' => 'Petersen',
            'email' => 'arnold@peterson.de',
            'password' => null,
            'birthday' => Carbon::createFromDate(1965,6,5),
            'entry_date' => Carbon::createFromDate(1998,1, 27),
            'location_id' => 2,
            'active' => true,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Hannah',
            'lastname' => 'Maier',
            'email' => 'hannah98@gmx.de',
            'password' => null,
            'birthday' => Carbon::createFromDate(1995,7,2),
            'entry_date' => Carbon::createFromDate(2011,12,20),
            'location_id' => 3,
            'active' => false,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Paula',
            'lastname' => 'Bauer',
            'email' => 'sweety@freemail.de',
            'password' => null,
            'birthday' => Carbon::createFromDate(2005,7,25),
            'entry_date' => Carbon::createFromDate(2013,8,15),
            'location_id' => 4,
            'active' => false,
            'is_admin' => false,
            'group_id' => 2,
        ]);
    }

}