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
use Zento\User;


class ExamUserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('exam_user')->delete();

        $exam = Exam::find(1);
        $exam->users()->attach(User::find(1));
        $exam->users()->attach(User::find(2));
        $exam->users()->attach(User::find(3));
        $exam->users()->updateExistingPivot(1, ['result' => '4. Kyu']);
        $exam->users()->updateExistingPivot(2, ['result' => '8. Kyu']);
        $exam->users()->updateExistingPivot(3, ['result' => '9. Kyu']);

        $exam = Exam::find(2);
        $exam->users()->attach(User::find(1));
        $exam->users()->attach(User::find(2));
        $exam->users()->attach(User::find(3));
        $exam->users()->updateExistingPivot(1, ['result' => '3. Kyu']);
        $exam->users()->updateExistingPivot(2, ['result' => '7. Kyu']);
        $exam->users()->updateExistingPivot(3, ['result' => '8. Kyu']);

        $exam = Exam::find(3);
        $exam->users()->attach(User::find(1));
        $exam->users()->attach(User::find(2));
        $exam->users()->attach(User::find(3));
        $exam->users()->updateExistingPivot(1, ['result' => '2. Kyu']);
        $exam->users()->updateExistingPivot(2, ['result' => '6. Kyu']);
        $exam->users()->updateExistingPivot(3, ['result' => '7. Kyu']);

        $exam = Exam::find(4);
        $exam->users()->attach(User::find(1));
        $exam->users()->attach(User::find(2));
        $exam->users()->attach(User::find(3));
        $exam->users()->updateExistingPivot(1, ['result' => '1. Kyu']);
        $exam->users()->updateExistingPivot(2, ['result' => '5. Kyu']);
        $exam->users()->updateExistingPivot(3, ['result' => '6. Kyu']);

        $exam = Exam::find(5);
        $exam->users()->attach(User::find(2));
        $exam->users()->attach(User::find(3));
        $exam->users()->attach(User::find(4));
        $exam->users()->updateExistingPivot(2, ['result' => '4. Kyu']);
        $exam->users()->updateExistingPivot(3, ['result' => '5. Kyu']);
        $exam->users()->updateExistingPivot(4, ['result' => '9. Kyu']);

        $exam = Exam::find(6);
        $exam->users()->attach(User::find(3));
        $exam->users()->attach(User::find(1));
        $exam->users()->updateExistingPivot(3, ['result' => '4. Kyu']);
        $exam->users()->updateExistingPivot(1, ['result' => '1. Dan']);

        $exam = Exam::find(7);
        $exam->users()->attach(User::find(2));
        $exam->users()->attach(User::find(6));
        $exam->users()->attach(User::find(9));
        $exam->users()->attach(User::find(14));
        $exam->users()->attach(User::find(15));
        $exam->users()->attach(User::find(16));
        $exam->users()->attach(User::find(17));
        $exam->users()->updateExistingPivot(2, ['result' => '3. Kyu']);
        $exam->users()->updateExistingPivot(6, ['result' => '7. Kyu']);
        $exam->users()->updateExistingPivot(9, ['result' => '6. Kyu']);
        $exam->users()->updateExistingPivot(14, ['result' => '1. Kyu']);
        $exam->users()->updateExistingPivot(15, ['result' => '2. Dan']);
        $exam->users()->updateExistingPivot(16, ['result' => '5. Kyu']);
        $exam->users()->updateExistingPivot(17, ['result' => '4. Kyu']);

        $exam = Exam::find(8);
        $exam->users()->attach(User::find(2));
        $exam->users()->attach(User::find(7));
        $exam->users()->attach(User::find(10));
        $exam->users()->attach(User::find(11));
        $exam->users()->attach(User::find(13));
        $exam->users()->updateExistingPivot(2, ['result' => '2. Kyu']);
        $exam->users()->updateExistingPivot(7, ['result' => '9. Kyu']);
        $exam->users()->updateExistingPivot(10, ['result' => '8. Kyu']);
        $exam->users()->updateExistingPivot(11, ['result' => '8. Kyu']);
        $exam->users()->updateExistingPivot(13, ['result' => '7. Kyu']);

        $exam = Exam::find(9);
        $exam->users()->attach(User::find(3));
        $exam->users()->attach(User::find(5));
        $exam->users()->attach(User::find(8));
        $exam->users()->attach(User::find(12));
        $exam->users()->attach(User::find(18));
        $exam->users()->updateExistingPivot(3, ['result' => '3. Kyu']);
        $exam->users()->updateExistingPivot(5, ['result' => '7. Kyu']);
        $exam->users()->updateExistingPivot(8, ['result' => '6. Kyu']);
        $exam->users()->updateExistingPivot(12, ['result' => '5. Kyu']);
        $exam->users()->updateExistingPivot(18, ['result' => '6. Kyu']);
    }
}