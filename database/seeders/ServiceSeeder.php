<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service')->insert([
            'srv_code' => mb_strtolower('mobil'),
            'srv_name' => 'Mobil',
            'srv_active' => 'Y',
            'srv_created_on' => date('Y-m-d H:i:s'),
        ]);
        DB::table('service')->insert([
            'srv_code' => mb_strtolower('sepedamotor'),
            'srv_name' => 'Sepeda Motor',
            'srv_active' => 'Y',
            'srv_created_on' => date('Y-m-d H:i:s'),
        ]);
    }
}
