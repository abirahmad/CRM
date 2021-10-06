<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_requisitions', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('shop_id')->default(1);
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('item_requisition_id');
            $table->string('item_type');
            $table->string('quantity');
            $table->string('size')->nullable()->comment('Inch');
            $table->string('image')->nullable();
            $table->text('comment')->nullable();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('item_requisition_id')->references('id')->on('item_requisitions')->onDelete('cascade');
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
        Schema::dropIfExists('brand_requisitions');
    }
}
