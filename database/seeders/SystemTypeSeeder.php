<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_type')->insert(['sty_group' => 'useraccess','sty_name' => 'Admin General','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'useraccess','sty_name' => 'Super Admin','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'useraccess','sty_name' => 'Admin Sepeda Motor','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'useraccess','sty_name' => 'Admin Mobil','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'useraccess','sty_name' => 'Admin Perpustakaan','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'color','sty_name' => 'Putih','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'color','sty_name' => 'Biru','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'color','sty_name' => 'Silver','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'fueltype','sty_name' => 'Solar','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'fueltype','sty_name' => 'Bensin','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'typecar','sty_name' => 'MPV','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'typecar','sty_name' => 'SUV','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'status','sty_name' => 'Available','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'status','sty_name' => 'Not Available','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'jaminan','sty_name' => 'KTP','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'bodytype','sty_name' => 'Scooter','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
        DB::table('system_type')->insert(['sty_group' => 'bodytype','sty_name' => 'Moped','sty_active' => 'Y','sty_created_on' => date('Y-m-d H:i:s'),]);
    }
}
