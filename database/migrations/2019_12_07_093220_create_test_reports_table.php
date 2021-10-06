<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('year');
            $table->enum('month', ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
            $table->string('title')->nullable()->comment('January 2019');
            $table->string('image')->nullable();
            $table->string('company')->nullable()->default('BUET')->comment('eg; BUET');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('cascade');
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
        Schema::dropIfExists('test_reports');
    }
}
