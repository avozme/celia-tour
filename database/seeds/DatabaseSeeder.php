<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(GuidedVisitTableSeeder::class);
        $this->call(HotspotTableSeeder::class);
        $this->call(JumpsTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(PortkeyTableSeeder::class);
        $this->call(UsersTableSeeder::class);        
        $this->call(ZonesTableSeeder::class);
        $this->call(SceneTableSeeder::class);
        $this->call(ResourceTableSeeder::class);
        $this->call(ScenesGuidedVisitTableSeeder::class);
        $this->call(HighlightsTableSeeder::class);
        $this->call(GallleryTableSeeder::class);
        $this->call(GallleryResourcesTableSeeder::class);
        $this->call(PortkeySceneTableSeeder::class);
        
    }
}
