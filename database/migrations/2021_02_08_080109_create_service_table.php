<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->bigIncrements('srv_id');
            $table->string('srv_code', 255);
            $table->string('srv_name',255);
            $table->char('srv_active',1)->default('Y');
            $table->timestamp('srv_created_on');
            $table->timestamp('srv_updated_on')->nullable();
            $table->bigInteger('srv_deleted_by')->nullable();
            $table->timestamp('srv_deleted_on')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service');
    }
}
