<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 14.07.15
 * Time: 17:00
 */

use Illuminate\Database\Seeder;
use Zento\Location;


class LocationTableSeeder extends Seeder {

    public function run()
    {
        DB::table('locations')->delete();

        Location::create([
            'name' => null,
            'zip' => 79312,
            'city' => 'Emmendingen',
            'street' => 'Albertstraße',
            'housenr' => '12',
            'country' => 'Deutschland'
        ]);

        Location::create([
            'name' => null,
            'zip' => 12345,
            'city' => 'Musterstadt',
            'street' => 'Musterstraße',
            'housenr' => '1',
            'country' => 'Deutschland'
        ]);

        Location::create([
            'name' => null,
            'zip' => 79312,
            'city' => 'Emmendingen',
            'street' => 'Blumenweg',
            'housenr' => '22A',
            'country' => 'Deutschland'
        ]);

        Location::create([
            'name' => null,
            'zip' => 79312,
            'city' => 'Emmendingen',
            'street' => 'Karl-Friedrich-Straße',
            'housenr' => '8',
            'country' => 'Deutschland'
        ]);
    }
}