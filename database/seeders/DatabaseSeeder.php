<?php

namespace Database\Seeders;

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
        $this->call(SystemSettingSeeder::class);
        $this->call(SystemTypeSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(SystemServiceSeeder::class);
        $this->call(UserMappingSeeder::class);
    }
}
