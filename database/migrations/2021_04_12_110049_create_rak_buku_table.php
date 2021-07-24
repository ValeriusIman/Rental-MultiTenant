<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRakBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rak_buku', function (Blueprint $table) {
            $table->bigIncrements('rb_id');
            $table->string('rb_number',255);
            $table->string('rb_kategori',255);
            $table->timestamp('rb_created_on');
            $table->timestamp('rb_updated_on')->nullable();
            $table->timestamp('rb_deleted_on')->nullable();
            $table->bigInteger('rb_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rak_buku');
    }
}
