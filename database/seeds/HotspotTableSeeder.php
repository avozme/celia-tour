<?php

use Illuminate\Database\Seeder;

class HotspotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("hotspots")->insert([
            'title' => 'Hotspot 1',
            'description' => 'primer hotspot',
            'pitch' => 3,
            'yaw' => 4,
            'type' => 1,
            'highlight_point' => false,
            'scene_id' => 2
        ]);

        DB::table("hotspots")->insert([
            'title' => 'Hotspot 2',
            'description' => 'segundo hotspot',
            'pitch' => 3,
            'yaw' => 4,
            'type' => 1,
            'highlight_point' => false,
            'scene_id' => 3
        ]);

        DB::table("hotspots")->insert([
            'title' => 'Hotspot 3',
            'description' => 'tercer hotspot',
            'pitch' => 3,
            'yaw' => 4,
            'type' => 1,
            'highlight_point' => false,
            'scene_id' => 1
        ]);
    }
}
