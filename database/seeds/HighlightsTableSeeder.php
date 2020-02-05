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
            'row' => '0',
            'column' => '0',
            'scene_file' => '1.jpg',
            'id_scene' => '1'
        ]);

        DB::table('highlights')->insert([
            'title' => 'HL2',
            'row' => '0',
            'column' => '1',
            'scene_file' => '2.jpg',
            'id_scene' => '2'
        ]);

        DB::table('highlights')->insert([
            'title' => 'HL3',
            'row' => '0',
            'column' => '2',
            'scene_file' => '3.jpg',
            'id_scene' => '3'
        ]);

        DB::table('highlights')->insert([
            'title' => 'HL4',
            'row' => '1',
            'column' => '0',
            'scene_file' => '4.jpg',
            'id_scene' => '4'
        ]);
    }
}
