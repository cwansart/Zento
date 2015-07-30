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
        $exam->users()->updateExistingPivot(2, ['result' => '3. Kyu']);

        $exam = Exam::find(8);
        $exam->users()->attach(User::find(2));
        $exam->users()->updateExistingPivot(2, ['result' => '2. Kyu']);

        $exam = Exam::find(9);
        $exam->users()->attach(User::find(3));
        $exam->users()->updateExistingPivot(3, ['result' => '3. Kyu']);
    }
}