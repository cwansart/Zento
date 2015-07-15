<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 15.07.15
 * Time: 02:17
 */
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Zento\SeminarUser;


class SeminarUserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('seminar_users')->delete();

        SeminarUser::create([
            'seminar_id' => 1,
            'user_id' => 1,
        ]);

        SeminarUser::create([
            'seminar_id' => 1,
            'user_id' => 2,
        ]);

        SeminarUser::create([
            'seminar_id' => 1,
            'user_id' => 3,
        ]);

        SeminarUser::create([
            'seminar_id' => 2,
            'user_id' => 1,
        ]);

        SeminarUser::create([
            'seminar_id' => 2,
            'user_id' => 2,
        ]);

        SeminarUser::create([
            'seminar_id' => 2,
            'user_id' => 3,
        ]);

        SeminarUser::create([
            'seminar_id' => 3,
            'user_id' => 1,
        ]);

        SeminarUser::create([
            'seminar_id' => 3,
            'user_id' => 3,
        ]);

        SeminarUser::create([
            'seminar_id' => 4,
            'user_id' => 1,
        ]);

        SeminarUser::create([
            'seminar_id' => 4,
            'user_id' => 2,
        ]);

        SeminarUser::create([
            'seminar_id' => 4,
            'user_id' => 3,
        ]);

        SeminarUser::create([
            'seminar_id' => 5,
            'user_id' => 1,
        ]);

        SeminarUser::create([
            'seminar_id' => 5,
            'user_id' => 2,
        ]);

        SeminarUser::create([
            'seminar_id' => 5,
            'user_id' => 4,
        ]);

        SeminarUser::create([
            'seminar_id' => 6,
            'user_id' => 5,
        ]);

        SeminarUser::create([
            'seminar_id' => 6,
            'user_id' => 4,
        ]);

        SeminarUser::create([
            'seminar_id' => 7,
            'user_id' => 2,
        ]);
    }
}