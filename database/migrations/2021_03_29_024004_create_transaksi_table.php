<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('tr_id');
            $table->bigInteger('tr_ss_id');
            $table->foreign('tr_ss_id','tbl_tr_ss_id_foreign')->references('ss_id')->on('system_setting');
            $table->bigInteger('tr_us_id');
            $table->foreign('tr_us_id','tbl_tr_us_id_foreign')->references('us_id')->on('users');
            $table->bigInteger('tr_srv_id');
            $table->foreign('tr_srv_id','tbl_tr_srv_id_foreign')->references('srv_id')->on('service');
            $table->bigInteger('tr_jaminan_id');
            $table->foreign('tr_jaminan_id','tbl_tr_jaminan_id_foreign')->references('sty_id')->on('system_type');
            $table->string('tr_name_customer',255);
            $table->string('tr_number',255);
            $table->date('tr_eta_date');
            $table->time('tr_eta_time');
            $table->date('tr_ata_date')->nullable();
            $table->time('tr_ata_time')->nullable();
            $table->bigInteger('tr_finish_by')->nullable();
            $table->timestamp('tr_finish_on')->nullable();
            $table->timestamp('tr_create_on');
            $table->timestamp('tr_updated_on')->nullable();
            $table->timestamp('tr_deleted_on')->nullable();
            $table->bigInteger('tr_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
