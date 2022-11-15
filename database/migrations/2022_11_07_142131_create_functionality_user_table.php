<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('functionality_user', function (Blueprint $table) {
            $table->bigInteger('functionality_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->foreign('functionality_id')->references('id')->on('functionalities');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('functionality_user');
    }
};
