<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSepedaMotorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sepeda_motor', function (Blueprint $table) {
            $table->bigIncrements('sp_id');
            $table->bigInteger('sp_as_id');
            $table->foreign('sp_as_id', 'tbl_sp_as_id_foreign')->references('as_id')->on('asset');
            $table->bigInteger('sp_warna_id');
            $table->foreign('sp_warna_id', 'tbl_sp_warna_id_foreign')->references('sty_id')->on('system_type');
            $table->bigInteger('sp_type_id');
            $table->foreign('sp_type_id', 'tbl_sp_type_id_foreign')->references('sty_id')->on('system_type');
            $table->integer('sp_status_id');
            $table->foreign('sp_status_id', 'tbl_sp_status_id_foreign')->references('sty_id')->on('system_type');
            $table->string('sp_bahan_bakar', 255);
            $table->string('sp_brand', 255);
            $table->string('sp_variant', 255);
            $table->string('sp_tahun_pembuatan', 255)->nullable();
            $table->integer('sp_harga');
            $table->integer('sp_cc');
            $table->string('sp_type_injeksi', 255)->nullable();
            $table->string('sp_kapasitas_tangki',255)->nullable();
            $table->string('sp_transmisi', 255);
            $table->string('sp_stnk', 255);
            $table->string('sp_bpkb', 255);
            $table->char('sp_active', 1)->default('Y');
            $table->timestamp('sp_created_on');
            $table->timestamp('sp_updated_on')->nullable();
            $table->timestamp('sp_deleted_on')->nullable();
            $table->bigInteger('sp_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sepeda_motor');
    }
}
