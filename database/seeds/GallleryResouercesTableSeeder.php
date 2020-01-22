<?php

use Illuminate\Database\Seeder;

class GallleryResouercesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("resources_gallery")->insert([
            'id' => '1',
            'resource_id' => '1',
            'gallery_id' => '1'
        ]);
    }
}
