<?php

use Illuminate\Database\Seeder;

class ResourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("resources")->insert([
                'id'=>'1',
                'title'=>'Recurso 1',
                'description'=>'Este es el recurso numero 1',
                'type'=>'image',
                'route'=>'/recursos/1'
        ])
        DB::table("resources")->insert([
            'id'=>'2',
            'title'=>'Recurso 2',
            'description'=>'Este es el recurso numero 2',
            'type'=>'audio',
            'route'=>'/recursos/2'
        ])
        DB::table("resources")->insert([
            'id'=>'3',
            'title'=>'Recurso 3',
            'description'=>'Este es el recurso numero 3',
            'type'=>'video',
            'route'=>'/recursos/3' 
        ])
        DB::table("resources")->insert([
            'id'=>'4',
            'title'=>'Recurso 4',
            'description'=>'Este es el recurso numero 4',
            'type'=>'document',
            'route'=>'/recurso/4'
        ])
    }
}
