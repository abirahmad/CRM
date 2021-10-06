<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_reference', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contact_id');
            $table->string('name');
            $table->unsignedBigInteger('relation_type_id');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('marriage_date')->nullable();

            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('relation_type_id')->references('id')->on('relation_type')->onDelete('cascade');
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
        Schema::dropIfExists('contact_reference');
    }
}
