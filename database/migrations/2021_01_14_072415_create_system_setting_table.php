<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_setting', function (Blueprint $table) {
            $table->bigIncrements('ss_id');
            $table->string('ss_relation',225);
            $table->bigInteger('ss_decimal_number');
            $table->char('ss_decimal_separator',1);
            $table->string('ss_logo',255)->nullable();
            $table->string('ss_name_space',255);
            $table->char('ss_system',1)->default('N');
            $table->char('ss_active',1)->default('Y');
            $table->timestamp('ss_created_on');
            $table->timestamp('ss_updated_on')->nullable();
            $table->bigInteger('ss_deleted_by')->nullable();
            $table->timestamp('ss_deleted_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_setting');
    }
}
