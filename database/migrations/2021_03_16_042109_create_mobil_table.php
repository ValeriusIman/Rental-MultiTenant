<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->bigIncrements('mb_id');
            $table->bigInteger('mb_as_id');
            $table->foreign('mb_as_id','tbl_mb_as_id_foreign')->references('as_id')->on('asset');
            $table->bigInteger('mb_color_id');
            $table->foreign('mb_color_id','tbl_mb_color_id_foreign')->references('sty_id')->on('system_type');
            $table->bigInteger('mb_fty_id');
            $table->foreign('mb_fty_id','tbl_mb_fty_id_foreign')->references('sty_id')->on('system_type');
            $table->bigInteger('mb_type_id');
            $table->foreign('mb_type_id','tbl_mb_type_id_foreign')->references('sty_id')->on('system_type');
             $table->bigInteger('mb_status_id');
            $table->foreign('mb_status_id','tbl_mb_status_id_foreign')->references('sty_id')->on('system_type');
            $table->string('mb_brand',255);
            $table->string('mb_variant',255);
            $table->integer('mb_built_year');
            $table->integer('mb_price');
            $table->integer('mb_cc');
            $table->string('mb_transmisi',255);
            $table->string('mb_girboks',255);
            $table->string('mb_stnk',255);
            $table->string('mb_bpkb',255);
            $table->integer('mb_pintu');
            $table->integer('mb_seat');
            $table->integer('mb_height');
            $table->integer('mb_length');
            $table->integer('mb_width');
            $table->integer('mb_tenaga');
            $table->char('mb_power_steering',1)->default('N');
            $table->char('mb_ac',1)->default('Y');
            $table->char('mb_kursi_lipat',1)->default('Y');
            $table->char('mb_abs',1)->default('Y');
            $table->char('mb_kamera_belakang',1)->default('Y');
            $table->char('mb_sabuk_pengaman',1)->default('Y');
            $table->char('mb_airbag_penumpang',1)->default('Y');
            $table->char('mb_airbag_pengemudi',1)->default('Y');
            $table->char('mb_active',1)->default('Y');
            $table->timestamp('mb_created_on');
            $table->timestamp('mb_updated_on')->nullable();
            $table->bigInteger('mb_deleted_by')->nullable();
            $table->timestamp('mb_deleted_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobil');
    }
}
