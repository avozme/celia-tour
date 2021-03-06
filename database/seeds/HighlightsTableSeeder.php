<?php

use Illuminate\Database\Seeder;

class HighlightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('highlights')->insert([
            'title' => 'HL1',
            'scene_file' => 'HL1.jpg',
            'id_scene' => '1',
            'position' => '1'
        ]);

        DB::table('highlights')->insert([
            'title' => 'HL2',
            'scene_file' => 'HL2.jpg',
            'id_scene' => '2',
            'position' => '2'
        ]);

        DB::table('highlights')->insert([
            'title' => 'HL3',
            'scene_file' => 'HL3.jpg',
            'id_scene' => '3',
            'position' => '3'
        ]);

        DB::table('highlights')->insert([
            'title' => 'HL4',
            'scene_file' => 'HL4.jpg',
            'id_scene' => '4',
            'position' => '4'
        ]);
    }
}
