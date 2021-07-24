<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset', function (Blueprint $table) {
            $table->bigIncrements('as_id');
            $table->bigInteger('as_ss_id');
            $table->foreign('as_ss_id','tbl_as_ss_id_foreign')->references('ss_id')->on('system_setting');
            $table->bigInteger('as_srv_id');
            $table->foreign('as_srv_id','tbl_as_srv_id_foreign')->references('srv_id')->on('service');
            $table->string('as_code',255);
            $table->char('as_active',1)->default('Y');
            $table->timestamp('as_created_on');
            $table->timestamp('as_updated_on')->nullable();
            $table->bigInteger('as_deleted_by')->nullable();
            $table->timestamp('as_deleted_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset');
    }
}
