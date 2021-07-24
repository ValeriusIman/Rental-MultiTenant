<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerbitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerbit', function (Blueprint $table) {
            $table->bigIncrements('pn_id');
            $table->string('pn_name',255);
            $table->string('pn_alamat',255);
            $table->timestamp('pn_created_on');
            $table->timestamp('pn_updated_on')->nullable();
            $table->timestamp('pn_deleted_on')->nullable();
            $table->bigInteger('pn_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penerbit');
    }
}
