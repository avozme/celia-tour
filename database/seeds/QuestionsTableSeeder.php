<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("questions")->insert([
            'text'=>'¿Esto es una pregunta de prueba?',
            'type'=>'boolean',
            'key'=>'0',
            'show_clue'=>'0'
        ]);
    }
}
