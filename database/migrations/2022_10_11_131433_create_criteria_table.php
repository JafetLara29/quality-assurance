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
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->string('scenary');
            $table->string('description', 500);
            $table->string('state');
            $table->bigInteger('functionality_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();//Responsable
            $table->timestamps();

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
        Schema::dropIfExists('criteria');
    }
};
