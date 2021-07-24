<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'us_name' => 'System Administrator',
            'us_username' => 'system@system.com',
            'us_password' => Hash::make('localhost'),
            'us_system' => 'Y',
            'us_active' => 'Y',
            'us_created_on' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'us_name' => 'System Administrator1',
            'us_username' => 'system1@system1.com',
            'us_password' => Hash::make('localhost'),
            'us_system' => 'Y',
            'us_active' => 'N',
            'us_created_on' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'us_name' => 'Administrator',
            'us_username' => 'admin@admin.com',
            'us_password' => Hash::make('localhost'),
            'us_system' => 'N',
            'us_active' => 'Y',
            'us_created_on' => date('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'us_name' => 'Administrator1',
            'us_username' => 'admin1@admin1.com',
            'us_password' => Hash::make('localhost'),
            'us_system' => 'N',
            'us_active' => 'N',
            'us_created_on' => date('Y-m-d H:i:s'),
        ]);
    }
}
