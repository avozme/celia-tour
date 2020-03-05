<?php

use Illuminate\Database\Seeder;

class GuidedVisitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("guided_visits")->insert([
            'name' => 'Test visita',
            'description' => 'Esta visita guiada fue generada mediante una seed',
            'file_preview' => 'yLX3dEqChe2HS5sE7GvpUOT39fDMXZbD2vt8Lkhl.jpeg'
        ]);
    }
}
