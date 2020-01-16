<?php

use Illuminate\Database\Seeder;

class ScenesGuidedVisitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("scenes_guided_visit")->insert([
            'id_resources' => '1',
            'id_scenes' => '1',
            'id_guided_visit' => '1',
            'position' => '1'
        ]);
    }
}
