<?php

use Illuminate\Database\Seeder;

class GallleryResourcesTableSeeder extends Seeder
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
        DB::table("resources_gallery")->insert([
            'id' => '2',
            'resource_id' => '9',
            'gallery_id' => '1'
        ]);
        DB::table("resources_gallery")->insert([
            'id' => '3',
            'resource_id' => '10',
            'gallery_id' => '1'
        ]);
    }
}
