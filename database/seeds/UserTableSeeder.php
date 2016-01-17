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
            'password' => '1234',
            'birthday' => '01.01.1990',//Carbon::createFromDate(1990,1,1),
            'entry_date' => '01.01.2000',//Carbon::createFromDate(2000,1,1),
            'location_id' => 1,
            'active' => true,
            'is_admin' => true,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Martina',
            'lastname' => 'Mustermann',
            'email' => 'martina@mustermann.de',
            'password' => 'passwort',
            'birthday' => '01.01.1992',//Carbon::createFromDate(1992,1,1),
            'entry_date' => '01.01.2004', //Carbon::createFromDate(2004,1,1),
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
            'birthday' => '05.06.1965', //Carbon::createFromDate(1965,6,5),
            'entry_date' => '27.01.1998', //Carbon::createFromDate(1998,1, 27),
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
            'birthday' => '02.07.1995', //Carbon::createFromDate(1995,7,2),
            'entry_date' => '20.12.2011', //Carbon::createFromDate(2011,12,20),
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
            'birthday' => '25.07.2005', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '15.08.2013', //Carbon::createFromDate(2013,8,15),
            'location_id' => 4,
            'active' => false,
            'is_admin' => false,
            'group_id' => 2,
        ]);

        User::create([
            'firstname' => 'Ina',
            'lastname' => 'Müller',
            'email' => 'ina@mueller.de',
            'password' => null,
            'birthday' => '27.03.1989', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '18.07.2010', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Tanja',
            'lastname' => 'Kaufmann',
            'email' => 'tanja@kaufmann.de',
            'password' => null,
            'birthday' => '27.12.1988', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '22.08.2009', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Alisa',
            'lastname' => 'Kaufmann',
            'email' => 'alisa@kaufmann.de',
            'password' => null,
            'birthday' => '02.11.1994', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '22.08.2009', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Thomas',
            'lastname' => 'Schnitzler',
            'email' => 'thomy@schnitzler.de',
            'password' => null,
            'birthday' => '02.05.1975', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '08.02.2003', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Michael',
            'lastname' => 'Bozlofski',
            'email' => 'michi@bozli.de',
            'password' => null,
            'birthday' => '09.07.1973', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '22.12.1992', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Costa',
            'lastname' => 'Cordalis',
            'email' => 'super@saenger.de',
            'password' => null,
            'birthday' => '13.06.1987', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '22.12.1999', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Axel',
            'lastname' => 'Schweiß',
            'email' => 'axel@bschweiss.de',
            'password' => null,
            'birthday' => '18.09.1983', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '01.06.1998', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Leo',
            'lastname' => 'Pard',
            'email' => 'leo@pard.de',
            'password' => null,
            'birthday' => '24.10.2001', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '22.12.2008', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 2,
        ]);

        User::create([
            'firstname' => 'Anna',
            'lastname' => 'Param',
            'email' => 'anna@param.de',
            'password' => null,
            'birthday' => '12.07.1992', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '22.12.2001', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Arne',
            'lastname' => 'Töpfer',
            'email' => 'Arne@toepfer.de',
            'password' => null,
            'birthday' => '09.07.1977', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '22.12.1990', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Anna-Lena',
            'lastname' => 'Schnabelmüller-Steffens',
            'email' => 'ann@lena.de',
            'password' => null,
            'birthday' => '10.07.2005', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '01.06.2012', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => true,
            'is_admin' => false,
            'group_id' => 2,
        ]);

        User::create([
            'firstname' => 'Detlef',
            'lastname' => 'Treter',
            'email' => 'diddi@treter.de',
            'password' => null,
            'birthday' => '09.07.1969', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '18.11.2013', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => false,
            'is_admin' => false,
            'group_id' => 1,
        ]);

        User::create([
            'firstname' => 'Dieter',
            'lastname' => 'Merkur',
            'email' => 'dd@merkur.de',
            'password' => null,
            'birthday' => '24.03.1976', //Carbon::createFromDate(2005,7,25),
            'entry_date' => '01.03.1992', //Carbon::createFromDate(2013,8,15),
            'location_id' => 7,
            'active' => false,
            'is_admin' => false,
            'group_id' => 1,
        ]);
    }

}