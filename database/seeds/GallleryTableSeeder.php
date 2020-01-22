<?php

use Illuminate\Database\Seeder;

class GallleryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("galleries")->insert([
            'id' => '1',
            'title' => 'Galeria 1',
            'description' => 'Esta es la descripción de la galeria 1'
        ]);
    }
}
