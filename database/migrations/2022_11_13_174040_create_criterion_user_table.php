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
        Schema::create('criterion_user', function (Blueprint $table) {
            $table->bigInteger('criterion_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->foreign('criterion_id')->references('id')->on('criteria');
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
        Schema::dropIfExists('criterion_user');
    }
};
