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
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => '123',
            'type' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => '123',
            'type' => '0',
        ]);

        DB::table('users')->insert([
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => '123',
            'type' => '0',
        ]);

        DB::table('users')->insert([
            'name' => 'user4',
            'email' => 'user4@gmail.com',
            'password' => '123',
            'type' => '0',
        ]);
    }
}
