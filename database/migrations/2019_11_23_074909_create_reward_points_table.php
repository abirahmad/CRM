<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('given_by')->nullable();
            $table->unsignedBigInteger('point')->default(0);

            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('given_by')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

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
        Schema::dropIfExists('reward_points');
    }
}
