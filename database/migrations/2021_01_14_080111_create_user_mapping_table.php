<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_mapping', function (Blueprint $table) {
            $table->bigIncrements('ump_id');
            $table->bigInteger('ump_us_id')->unsigned();
            $table->foreign('ump_us_id','tbl_ump_us_id_foreign')->references('us_id')->on('users');
            $table->bigInteger('ump_ss_id')->unsigned();
            $table->foreign('ump_ss_id','tbl_ump_ss_id_foreign')->references('ss_id')->on('system_setting');
            $table->char('ump_default',1)->default('N');
            $table->char('ump_active',1)->default('Y');
            $table->string('ump_level',255);
            $table->timestamp('ump_created_on');
            $table->timestamp('ump_updated_on')->nullable();
            $table->bigInteger('ump_deleted_by')->nullable();
            $table->timestamp('ump_deleted_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_mapping');
    }
}
