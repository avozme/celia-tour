<?php

use Illuminate\Database\Seeder;

class PortkeySceneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("portkey_scene")->insert([
            'id' => '1',
            'portkey_id' => '1',
            'scene_id' => '1'
        ]);

        DB::table("portkey_scene")->insert([
            'id' => '2',
            'portkey_id' => '2',
            'scene_id' => '2'
        ]);

        DB::table("portkey_scene")->insert([
            'id' => '3',
            'portkey_id' => '3',
            'scene_id' => '3'
        ]);
    }
}
