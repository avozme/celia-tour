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
            'name' => 'rosen',
            'email' => 'rosen@gmail.com',
            'password' => '$2y$10$Kc242KYbUxzB0wBjYSENbuoDjWp05lULHAJEnH0/ifLd3xu6UD6fK',
            'type' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => '$2y$10$8Ezt3Cg9pTwwSnjF62/kY.HSftOFKyH023Tyio5FG/crxLvEKlIZG',
            'type' => '0',
        ]);

        DB::table('users')->insert([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => '$2y$10$ux/UVYthWHRz.98tKbUytOuevy1IPAcdfripW.g6c8ydflJ.Cc5SO',
            'type' => '0',
        ]);

        DB::table('users')->insert([
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => '$2y$10$TJNf6g53umFj9YtM1bYVzuZpBgzZMASzLhH2BdN.LlicLVNUmfspe',
            'type' => '0',
        ]);

        DB::table('users')->insert([
            'name' => 'user4',
            'email' => 'user4@gmail.com',
            'password' => '$2y$10$5Wr1McEnGzJz2ODNRXTMwOwLYYlH2O4bjvlYdIfjgi.aFN.qxxoK2',
            'type' => '0',
        ]);
    }
}
