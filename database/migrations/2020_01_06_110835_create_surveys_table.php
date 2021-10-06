<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('link');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('created_by')->comment('Which contact is added the site !!')->nullable();
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
