<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Celia Viñas',
            'email' => 'CeliaV@gmail.com',
            'password' => '123',
            'type' => '0',
        ]);

        DB::table('users')->insert([
            'name' => 'Picachu',
            'email' => 'picachu@gmail.com',
            'password' => '123',
            'type' => '0',
        ]);

        DB::table('users')->insert([
            'name' => 'R2D2',
            'email' => 'r2d2@gmail.com',
            'password' => '123',
            'type' => '0',
        ]);

        DB::table('users')->insert([
            'name' => 'CRUD',
            'email' => 'crud@gmail.com',
            'password' => '123',
            'type' => '1',
        ]);
    }
}
