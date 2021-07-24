<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_setting')->insert([
            'ss_relation' => 'Multi Mutiara Rental',
            'ss_decimal_number' => '2',
            'ss_decimal_separator' => '.',
            'ss_thousand_separator' => ',',
            'ss_name_space' => 'MMR',
            'ss_system' => 'Y',
            'ss_active' => 'Y',
            'ss_created_on' => date('Y-m-d H:i:s'),
        ]);
        DB::table('system_setting')->insert([
            'ss_relation' => 'Global Jaya Rental',
            'ss_decimal_number' => '2',
            'ss_decimal_separator' => ',',
            'ss_thousand_separator' => ',',
            'ss_name_space' => 'GJR',
            'ss_system' => 'N',
            'ss_active' => 'Y',
            'ss_created_on' => date('Y-m-d H:i:s'),
        ]);
    }
}
