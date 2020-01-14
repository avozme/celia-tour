<?php

use Illuminate\Database\Seeder;

class ZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zones')->insert([
            'name' => 'Zona 1',
            'file_image' => '1.png',
            'file_miniature' => '1.png',
            'position' => 2,
            'initial_zone' => true,
        ]);

        DB::table('zones')->insert([
            'name' => 'Zona 2',
            'file_image' => '2.jpg',
            'file_miniature' => '2.jpg',
            'position' => 4,
            'initial_zone' => false,
        ]);

        DB::table('zones')->insert([
            'name' => 'Zona 3',
            'file_image' => '3.jpg',
            'file_miniature' => '3.jpg',
            'position' => 1,
            'initial_zone' => false,
        ]);

        DB::table('zones')->insert([
            'name' => 'Zona 4',
            'file_image' => '4.jpg',
            'file_miniature' => '4.jpg',
            'position' => 3,
            'initial_zone' => false,
        ]);
    }
}
