<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        //$this->call(GuidedVisitTableSeeder::class);
        $this->call(ResourceTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(ZonesTableSeeder::class);
    }
}
