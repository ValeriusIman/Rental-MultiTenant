<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver', function (Blueprint $table) {
            $table->bigIncrements('dr_id');
            $table->bigInteger('dr_ss_id');
            $table->foreign('dr_ss_id','tbl_dr_ss_id_foreign')->references('ss_id')->on('system_setting');
            $table->string('dr_name',255);
            $table->string('dr_phone',255);
            $table->string('dr_address',255);
            $table->char('dr_status',1)->default('Y');
            $table->char('dr_active',1)->default('Y');
            $table->timestamp('dr_created_on');
            $table->timestamp('dr_updated_on')->nullable();
            $table->bigInteger('dr_deleted_by')->nullable();
            $table->timestamp('dr_deleted_on')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver');
    }
}
