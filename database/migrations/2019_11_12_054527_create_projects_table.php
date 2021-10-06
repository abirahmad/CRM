<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('unit_id');
            $table->string('responsible_name');
            $table->string('responsible_phone_no');
            $table->string('type');
            $table->unsignedBigInteger('structure_type_id')->nullable();
            $table->unsignedBigInteger('created_by')->comment('Which contact is added the site !!')->nullable();
            $table->string('size');
            $table->string('product_usage_qty');
            $table->string('comment');
            $table->boolean('status')->default(0)->comment('0=>Un confirmed, 1=>confirmed');

            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('structure_type_id')->references('id')->on('structure_types')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('contacts')->onDelete('cascade');
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
        Schema::dropIfExists('projects');
    }
}
