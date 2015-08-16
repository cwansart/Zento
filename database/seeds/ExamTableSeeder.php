<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14.07.15
 * Time: 17:02
 */
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Zento\Exam;


class ExamTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('exams')->delete();

        Exam::create([
            'date' => '01.01.2008', //Carbon::createFromDate(2008,1,1),
            'location_id' => 5
        ]);

        Exam::create([
            'date' => '01.01.2009', //Carbon::createFromDate(2009,1,1),
            'location_id' => 5
        ]);

        Exam::create([
            'date' => '01.01.2009', //Carbon::createFromDate(2009,1,1),
            'location_id' => 5
        ]);

        Exam::create([
            'date' => '01.01.2010', //Carbon::createFromDate(2010,1,1),
            'location_id' => 5
        ]);

        Exam::create([
            'date' => '01.01.2011', //Carbon::createFromDate(2011,1,1),
            'location_id' => 5
        ]);

        Exam::create([
            'date' => '01.01.2012', //Carbon::createFromDate(2012,1,1),
            'location_id' => 5
        ]);

        Exam::create([
            'date' => '14.01.2012', //Carbon::createFromDate(2012,1,14),
            'location_id' => 6
        ]);

        Exam::create([
            'date' => '01.01.2013', //Carbon::createFromDate(2013,1,1),
            'location_id' => 5
        ]);

        Exam::create([
            'date' => '08.01.2013', //Carbon::createFromDate(2013,1,8),
            'location_id' => 6
        ]);
    }
}