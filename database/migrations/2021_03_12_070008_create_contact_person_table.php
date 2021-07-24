<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_person', function (Blueprint $table) {
            $table->bigIncrements('cp_id');
            $table->bigInteger('cp_ss_id');
            $table->foreign('cp_ss_id','tbl_cp_ss_id_foreign')->references('ss_id')->on('system_setting');
            $table->string('cp_name',255);
            $table->string('cp_phone',255);
            $table->string('cp_address',255);
            $table->char('cp_active',1)->default('Y');
            $table->timestamp('cp_created_on');
            $table->timestamp('cp_updated_on')->nullable();
            $table->bigInteger('cp_deleted_by')->nullable();
            $table->timestamp('cp_deleted_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_person');
    }
}
