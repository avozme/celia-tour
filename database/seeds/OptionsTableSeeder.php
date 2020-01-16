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
                'value'=>'celia-logo.png',
                'type'=>'file'

        ]);

        DB::table("options")->insert([
                'id'=>'2',
                'key'=>'Imagen de fondo',
                'value'=>'celia-vinas.jpg',
                'type'=>'file'
        ]);

        DB::table("options")->insert([
                'id'=>'3',
                'key'=>'Título',
                'value'=>'CELIA VIÑAS 360',
                'type'=>'text'
        ]);

        DB::table("options")->insert([
                'id'=>'4',
                'key'=>'Descripción',
                'value'=>'Descripcion',
                'type'=>'textarea'
        ]);

        DB::table("options")->insert([
                'id'=>'5',
                'key'=>'Tipo de fuente',
                'value'=>'arial',
                'type'=>'list'
        ]);
    }
}
