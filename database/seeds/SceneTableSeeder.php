<?php

use Illuminate\Database\Seeder;

class SceneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("scenes")->insert([
            'name' => 'Mi primera escena',
            'pitch' => 3,
            'yaw' => 4,
            'top' => 20,
            'left' => '50',
            'directory_name' => 'midirectorio',
            'id_zone' => 1
        ]);
    }
}
