<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('structure_type_id');
            $table->unsignedBigInteger('created_by')->comment('Which contact is added the site !!')->nullable();
            $table->string('owner_name');
            $table->string('owner_phone_no');
            $table->string('address');
            $table->boolean('status')->default(0)->comment('1=>Confirmed, 0=>Not Confirmed');
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('structure_type_id')->references('id')->on('structure_types')->onDelete('cascade');
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
        Schema::dropIfExists('sites');
    }
}
