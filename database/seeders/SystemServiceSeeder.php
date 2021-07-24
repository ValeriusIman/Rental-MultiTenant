<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_service')->insert([
            'ssr_ss_id' => 1,
            'ssr_srv_id' => 1,
            'ssr_active' => 'Y',
            'ssr_created_on' => date('Y-m-d H:i:s'),
        ]);
        DB::table('system_service')->insert([
            'ssr_ss_id' => 2,
            'ssr_srv_id' => 1,
            'ssr_active' => 'Y',
            'ssr_created_on' => date('Y-m-d H:i:s'),
        ]);
    }
}
