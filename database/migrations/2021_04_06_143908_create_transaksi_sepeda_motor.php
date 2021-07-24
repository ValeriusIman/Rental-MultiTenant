<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiSepedaMotor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_sepeda_motor', function (Blueprint $table) {
            $table->bigIncrements('tsm_id');
            $table->bigInteger('tsm_as_id');
            $table->foreign('tsm_as_id','tbl_tsm_as_id_foreign')->references('as_id')->on('asset');
            $table->bigInteger('tsm_tr_id');
            $table->foreign('tsm_tr_id','tbl_tsm_tr_id_foreign')->references('tr_id')->on('transaksi');
            $table->integer('tsm_harga');
            $table->integer('tsm_denda')->nullable();
            $table->timestamp('tsm_created_on');
            $table->timestamp('tsm_updated_on')->nullable();
            $table->timestamp('tsm_deleted_on')->nullable();
            $table->bigInteger('tsm_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_sepeda_motor');
    }
}
