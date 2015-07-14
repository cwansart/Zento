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
            'title' => 'Dänemark Traingscamp 2011',
            'date' => Carbon::createFromDate(2011,8,1)
        ]);

        Seminar::create([
            'location_id' => 7,
            'title' => 'Dänemark Traingscamp 2012',
            'date' => Carbon::createFromDate(2012,8,1)
        ]);

        Seminar::create([
            'location_id' => 7,
            'title' => 'Dänemark Traingscamp 2013',
            'date' => Carbon::createFromDate(2014,4,1)
        ]);

        Seminar::create([
            'location_id' => 7,
            'title' => 'Dänemark Traingscamp 2014',
            'date' => Carbon::createFromDate(2014,4,1)
        ]);

        Seminar::create([
            'location_id' => 5,
            'title' => 'Jo Lehrgang',
            'date' => Carbon::createFromDate(2008,10,22)
        ]);

        Seminar::create([
            'location_id' => 5,
            'title' => 'Chi Gong mit Wing Chun',
            'date' => Carbon::createFromDate(2014,4,25)
        ]);

        Seminar::create([
            'location_id' => 5,
            'title' => 'Bo Lehrgang',
            'date' => Carbon::createFromDate(2014,7,5)
        ]);
    }
}