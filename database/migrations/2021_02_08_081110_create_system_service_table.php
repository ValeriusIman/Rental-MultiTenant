<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_service', function (Blueprint $table) {
            $table->bigIncrements('ssr_id');
            $table->bigInteger('ssr_ss_id');
            $table->foreign('ssr_ss_id','tbl_ssr_ss_id_foreign')->references('ss_id')->on('system_setting');
            $table->bigInteger('ssr_srv_id');
            $table->foreign('ssr_srv_id','tbl_ssr_srv_id_foreign')->references('srv_id')->on('service');
            $table->char('ssr_active',1)->default('Y');
            $table->timestamp('ssr_created_on');
            $table->timestamp('ssr_updated_on')->nullable();
            $table->bigInteger('ssr_deleted_by')->nullable();
            $table->timestamp('ssr_deleted_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_service');
    }
}
