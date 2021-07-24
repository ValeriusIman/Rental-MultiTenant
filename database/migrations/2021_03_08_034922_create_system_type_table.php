<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_type', function (Blueprint $table) {
            $table->bigIncrements('sty_id');
            $table->string('sty_group',255);
            $table->string('sty_name',255);
            $table->char('sty_active',1)->default('Y');
            $table->timestamp('sty_created_on');
            $table->timestamp('sty_updated_on')->nullable();
            $table->bigInteger('sty_deleted_by')->nullable();
            $table->timestamp('sty_deleted_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_type');
    }
}
