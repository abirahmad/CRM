<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('product_id');
            $table->string('quantity');
            $table->string('date');
            $table->string('location');
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->text('details')->nullable();

            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('upazila_id')->references('id')->on('upazilas')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
