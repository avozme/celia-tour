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
            'name' => 'maria',
            'email' => 'maria@gmail.com',
            'password' => '$2y$10$8Ezt3Cg9pTwwSnjF62/kY.HSftOFKyH023Tyio5FG/crxLvEKlIZG',
            'type' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'alex',
            'email' => 'alex@gmail.com',
            'password' => '$2y$10$ux/UVYthWHRz.98tKbUytOuevy1IPAcdfripW.g6c8ydflJ.Cc5SO',
            'type' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'angel',
            'email' => 'angel@gmail.com',
            'password' => '$2y$10$TJNf6g53umFj9YtM1bYVzuZpBgzZMASzLhH2BdN.LlicLVNUmfspe',
            'type' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'carmen',
            'email' => 'carmen@gmail.com',
            'password' => '$2y$10$5Wr1McEnGzJz2ODNRXTMwOwLYYlH2O4bjvlYdIfjgi.aFN.qxxoK2',
            'type' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'jose',
            'email' => 'jose@gmail.com',
            'password' => '$2y$10$kq9BelB9ZQ0qUiwHuxwuaOHA6AquGeWP.cm86SpK5mAhCPA9afM6e',
            'type' => '1',
        ]);
    }
}
