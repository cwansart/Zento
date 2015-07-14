<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14.07.15
 * Time: 17:02
 */
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Zento\ExamResult;


class ExamResultTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('exam_results')->delete();

        ExamResult::create([
            'exam_id' => 1,
            'user_id' => 1,
            'result' => '4. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 1,
            'user_id' => 2,
            'result' => '8. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 1,
            'user_id' => 3,
            'result' => '9. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 2,
            'user_id' => 1,
            'result' => '3. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 2,
            'user_id' => 2,
            'result' => '7. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 2,
            'user_id' => 3,
            'result' => '8. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 3,
            'user_id' => 1,
            'result' => '2. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 3,
            'user_id' => 2,
            'result' => '6. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 3,
            'user_id' => 3,
            'result' => '7. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 4,
            'user_id' => 1,
            'result' => '1. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 4,
            'user_id' => 2,
            'result' => '5. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 4,
            'user_id' => 3,
            'result' => '6. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 5,
            'user_id' => 2,
            'result' => '4. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 5,
            'user_id' => 3,
            'result' => '5. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 5,
            'user_id' => 4,
            'result' => '9. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 6,
            'user_id' => 3,
            'result' => '4. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 6,
            'user_id' => 1,
            'result' => '1. Dan'
        ]);

        ExamResult::create([
            'exam_id' => 7,
            'user_id' => 2,
            'result' => '3. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 8,
            'user_id' => 2,
            'result' => '2. Kyu'
        ]);

        ExamResult::create([
            'exam_id' => 9,
            'user_id' => 3,
            'result' => '3. Kyu'
        ]);
    }
}