<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("options")->insert([
                'id'=>'1',
                'key'=>'Logo',
                'value'=>'celia-logo.png'
        ]);

        DB::table("options")->insert([
                'id'=>'2',
                'key'=>'Imagen de fondo',
                'value'=>'celia-vinas.jpg'
        ]);

        DB::table("options")->insert([
                'id'=>'3',
                'key'=>'Titulo',
                'value'=>'CELIA VIÑAS 360'
        ]);

        DB::table("options")->insert([
                'id'=>'4',
                'key'=>'Descripcion',
                'value'=>'Descripcion'
        ]);
    }
}
