<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14.07.15
 * Time: 17:01
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Zento\Seminar;


class SeminarTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('seminars')->delete();

        Seminar::create([
            'location_id' => 7,
            'title' => 'Dänemark Trainingscamp 2011',
            'date' => '01.08.2011', //Carbon::createFromDate(2011,8,1)
        ]);

        Seminar::create([
            'location_id' => 7,
            'title' => 'Dänemark Trainingscamp 2012',
            'date' => '01.08.2012', //Carbon::createFromDate(2012,8,1)
        ]);

        Seminar::create([
            'location_id' => 7,
            'title' => 'Dänemark Trainingscamp 2013',
            'date' => '01.04.2014', //Carbon::createFromDate(2014,4,1)
        ]);

        Seminar::create([
            'location_id' => 7,
            'title' => 'Dänemark Trainingscamp 2014',
            'date' => '01.04.2014', //Carbon::createFromDate(2014,4,1)
        ]);

        Seminar::create([
            'location_id' => 5,
            'title' => 'Jo Lehrgang',
            'date' => '22.10.2008', //Carbon::createFromDate(2008,10,22)
        ]);

        Seminar::create([
            'location_id' => 5,
            'title' => 'Chi Gong mit Wing Chun',
            'date' => '25.04.2014', //Carbon::createFromDate(2014,4,25)
        ]);

        Seminar::create([
            'location_id' => 5,
            'title' => 'Bo Lehrgang',
            'date' => '05.07.2014', //Carbon::createFromDate(2014,7,5)
        ]);
    }
}