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
        ]);
        DB::table("resources")->insert([
            'id'=>'2',
            'title'=>'Recurso 2',
            'description'=>'Este es el recurso numero 2',
            'type'=>'audio',
            'route'=>'/recursos/2'
        ]);
        DB::table("resources")->insert([
            'id'=>'3',
            'title'=>'Recurso 3',
            'description'=>'Este es el recurso numero 3',
            'type'=>'video',
            'route'=>'89968576' 
        ]);
        DB::table("resources")->insert([
            'id'=>'4',
            'title'=>'Recurso 4',
            'description'=>'Este es el recurso numero 4',
            'type'=>'document',
            'route'=>'/recurso/4'
        ]);
        DB::table("resources")->insert([
            'id'=>'5',
            'title'=>'Recurso 5',
            'description'=>'Este es el recurso numero 4',
            'type'=>'video',
            'route'=>'175777474'
        ]);
        DB::table("resources")->insert([
            'id'=>'6',
            'title'=>'Recurso 6',
            'description'=>'Este es el recurso numero 4',
            'type'=>'video',
            'route'=>'231191863'
        ]);
        DB::table("resources")->insert([
            'id'=>'7',
            'title'=>'Recurso 7',
            'description'=>'Este es el recurso numero 4',
            'type'=>'video',
            'route'=>'201556977'
        ]);
        DB::table("resources")->insert([
            'id'=>'8',
            'title'=>'Recurso 8',
            'description'=>'Este es el recurso numero 4',
            'type'=>'video',
            'route'=>'156212670'
        ]);
        DB::table("resources")->insert([
            'id'=>'9',
            'title'=>'Recurso 9',
            'description'=>'Este es el recurso numero 4',
            'type'=>'image',
            'route'=>'img/resources/1.png'
        ]);
        DB::table("resources")->insert([
            'id'=>'10',
            'title'=>'Recurso 10',
            'description'=>'Este es el recurso numero 4',
            'type'=>'image',
            'route'=>'img/resources/2.png'
        ]);
        DB::table("resources")->insert([
            'id'=>'11',
            'title'=>'Recurso 11',
            'description'=>'',
            'type'=>'image',
            'route'=>'img/resources/HL1.jpg'
        ]);
        DB::table("resources")->insert([
            'id'=>'12',
            'title'=>'Recurso 12',
            'description'=>'',
            'type'=>'image',
            'route'=>'img/resources/HL2.jpg'
        ]);
        DB::table("resources")->insert([
            'id'=>'13',
            'title'=>'Recurso 13',
            'description'=>'',
            'type'=>'image',
            'route'=>'img/resources/HL3.jpg'
        ]);
        DB::table("resources")->insert([
            'id'=>'14',
            'title'=>'Recurso 14',
            'description'=>'',
            'type'=>'image',
            'route'=>'img/resources/HL4.jpg'
        ]);
    }
}
