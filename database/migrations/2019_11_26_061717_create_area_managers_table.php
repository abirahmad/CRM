<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_managers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('areaid');
            $table->string('areaManagerName');
            $table->string('strOfficeEmail');
            $table->string('strEmployeeName');
            $table->string('strDesignation');
            $table->string('strContactNo1');
            $table->integer('intLevel');
            $table->integer('intUnitId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_managers');
    }
}
