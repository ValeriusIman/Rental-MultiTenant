<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_mapping')->insert([
            'ump_us_id' => '1',
            'ump_ss_id' => '1',
            'ump_default' => 'Y',
            'ump_active' => 'Y',
            'ump_level_id' => '1',
            'ump_created_on' => date('Y-m-d H:i:s'),
        ]);
        DB::table('user_mapping')->insert([
            'ump_us_id' => '1',
            'ump_ss_id' => '2',
            'ump_default' => 'N',
            'ump_active' => 'Y',
            'ump_level_id' => '1',
            'ump_created_on' => date('Y-m-d H:i:s'),
        ]);
        DB::table('user_mapping')->insert([
            'ump_us_id' => '3',
            'ump_ss_id' => '1',
            'ump_default' => 'Y',
            'ump_active' => 'Y',
            'ump_level_id' => '2',
            'ump_created_on' => date('Y-m-d H:i:s'),
        ]);
    }
}
