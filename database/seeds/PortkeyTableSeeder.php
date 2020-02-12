<?php

use Illuminate\Database\Seeder;

class PortkeyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table("portkeys")->insert([
                'id'=>'1',
                'name'=>'prueba1',
                
        ]);

         DB::table("portkeys")->insert([
                'id'=>'2',
                'name'=>'prueba2',
                
        ]);

         DB::table("portkeys")->insert([
                'id'=>'3',
                'name'=>'prueba3',
                
        ]);
    }
}
