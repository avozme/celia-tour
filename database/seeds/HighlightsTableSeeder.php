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
            'scene_file' => '',
            'id_scene' => ''
        ]);
    }
}
