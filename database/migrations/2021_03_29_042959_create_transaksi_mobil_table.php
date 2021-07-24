<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiMobilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_mobil', function (Blueprint $table) {
            $table->bigIncrements('trm_id');
            $table->bigInteger('trm_as_id');
            $table->foreign('trm_as_id','tbl_as_id_foreign')->references('as_id')->on('asset');
            $table->bigInteger('trm_tr_id');
            $table->foreign('trm_tr_id','tbl_trm_tr_id_foreign')->references('tr_id')->on('transaksi');
            $table->bigInteger('trm_dr_id')->nullable();
            $table->foreign('trm_dr_id','tbl_trm_dr_id_foreign')->references('dr_id')->on('driver');
            $table->integer('trm_price')->nullable();
            $table->integer('trm_denda')->nullable();
            $table->timestamp('trm_created_on');
            $table->timestamp('trm_updated_on')->nullable();
            $table->timestamp('trm_deleted_on')->nullable();
            $table->bigInteger('trm_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_mobil');
    }
}
