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
        $this->call(UserSeeder::class);
        $this->call(RoomTypeSeeder::class);
        $this->call(RoomFacilitySeeder::class);
        $this->call(RoomAttributeSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
