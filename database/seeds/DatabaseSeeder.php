<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UserTableSeeder');
        $this->command->info('User table seeded');

        $this->call('LocationTableSeeder');
        $this->command->info('Location table seeded');

        $this->call('GroupTableSeeder');
        $this->command->info('Group table seeded');

        $this->command->info('Seeding complete!');
        Model::reguard();
    }
}
