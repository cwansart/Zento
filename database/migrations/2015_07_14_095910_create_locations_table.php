<?php

use Zento\Location;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('zip');
            $table->string('city');
            $table->string('street');
            $table->string('housenr');
            $table->string('country');
            $table->softDeletes();
            $table->timestamps();
        });

        // We need to ensure that there's at least one location, because the users table
        // defaults to id 1
        Location::create([
            'name' => null,
            'zip' => 1337,
            'city' => 'Musterstadt',
            'street' => 'Mustertraße',
            'housenr' => '42',
            'country' => 'Musterland'
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('locations');
    }
}
