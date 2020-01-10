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
                'key'=>'prueba 1',
                'value'=>'terminator.jpg'
        ]);

        DB::table("options")->insert([
                'id'=>'2',
                'key'=>'prueba 2',
                'value'=>'esto es una prueba 2'
        ]);

        DB::table("options")->insert([
                'id'=>'3',
                'key'=>'prueba 3',
                'value'=>'esto es una prueba 3'
        ]);

        DB::table("options")->insert([
                'id'=>'4',
                'key'=>'prueba 4',
                'value'=>'esto es una prueba 4'
        ]);
    }
}
