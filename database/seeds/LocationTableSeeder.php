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

        Location::create([
            'name' => 'Jahnhalle',
            'zip' => 79312,
            'city' => 'Emmendingen',
            'street' => 'Jahnstraße',
            'housenr' => '7',
            'country' => 'Deutschland'
        ]);

        Location::create([
            'name' => 'Grundschulhalle',
            'zip' => 79312,
            'city' => 'Wasser',
            'street' => 'Hauptstraße',
            'housenr' => '54',
            'country' => 'Deutschland'
        ]);

        Location::create([
            'name' => null,
            'zip' => 6960,
            'city' => 'Hvide Sande',
            'street' => '',
            'housenr' => '',
            'country' => 'Dänemark'
        ]);

        Location::create([
            'name' => null,
            'zip' => 79312,
            'city' => 'Emmendingen',
            'street' => '',
            'housenr' => '',
            'country' => 'Deutschland'
        ]);
    }
}