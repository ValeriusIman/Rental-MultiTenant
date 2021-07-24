<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('mn_id');
            $table->bigInteger('mn_srv_id')->nullable();
            $table->foreign('mn_srv_id','tbl_mn_srv_id_foreign')->references('srv_id')->on('service');
            $table->string('mn_name',255);
            $table->string('mn_icon',255);
            $table->string('mn_route',255);
            $table->char('mn_active',1)->nullable()->default('Y');
            $table->timestamp('mn_created_on');
            $table->timestamp('mn_updated_on')->nullable();
            $table->timestamp('mn_deleted_on')->nullable();
            $table->bigInteger('mn_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
