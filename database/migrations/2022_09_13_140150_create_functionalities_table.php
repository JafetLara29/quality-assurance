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
        Schema::create('functionalities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 1000);
            $table->string('state');
            $table->bigInteger('module_id')->unsigned();
            $table->timestamps();

            $table->foreign('module_id')->references('id')->on('modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('functionalities');
    }
};
