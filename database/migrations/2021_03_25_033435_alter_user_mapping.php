<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_mapping', function (Blueprint $table) {
            $table->dropColumn('ump_level');
            $table->bigInteger('ump_level_id')->unsigned();
            $table->foreign('ump_level_id', 'tbl_ump_level_id_foreign')->references('sty_id')->on('system_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_mapping', function (Blueprint $table) {
            $table->dropColumn('ump_level_id');
        });
    }
}
