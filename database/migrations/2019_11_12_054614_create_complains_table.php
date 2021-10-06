<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('created_by');
            $table->text('message');
            $table->string('images')->nullable();

            $table->text('reply_message')->nullable();

            $table->boolean('status')->default(0)->comment('0=>Inactive, 1=>Resolved');

            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
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
        Schema::dropIfExists('complains');
    }
}
