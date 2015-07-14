<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14.07.15
 * Time: 17:01
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Zento\Group;


class GroupTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('groups')->delete();

        Group::create([
            'name' => 'Erwachsene'
        ]);

        Group::create([
            'name' => 'Kinder'
        ]);
    }
}