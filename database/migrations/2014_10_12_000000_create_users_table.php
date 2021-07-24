<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('us_id');
            $table->string('us_name',255);
            $table->string('us_username',255)->unique();
            $table->string('us_password',255);
            $table->char('us_system',1)->default('N');
            $table->char('us_active',1)->default('Y');
            $table->timestamp('us_created_on');
            $table->timestamp('us_updated_on')->nullable();
            $table->bigInteger('us_deleted_by')->nullable();
            $table->timestamp('us_deleted_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
