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
            'name' => 'Sótano',
            'file_image' => 'sotano.png',
            'file_miniature' => 'sotano.png',
            'position' => 1,
        ]);

        DB::table('zones')->insert([
            'name' => 'Planta baja',
            'file_image' => 'plantabaja.png',
            'file_miniature' => 'plantabaja.png',
            'position' => 2,
        ]);

        DB::table('zones')->insert([
            'name' => 'Primera planta',
            'file_image' => 'planta1.png',
            'file_miniature' => 'planta1.png',
            'position' => 3,
        ]);

        DB::table('zones')->insert([
            'name' => 'Segunda planta',
            'file_image' => 'planta2.png',
            'file_miniature' => 'planta2.png',
            'position' => 4,
        ]);

        DB::table('zones')->insert([
            'name' => 'Tejado',
            'file_image' => 'tejado.png',
            'file_miniature' => 'tejado.png',
            'position' => 5,
        ]);
    }
}
