<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('api_token', 100);
            $table->unsignedBigInteger('unit_id');

            $table->string('email');
            $table->string('is_approved')->default(0)->comment('1=Approved , 0=Not Approved');
            $table->string('username')->unique();
            $table->string('phone_no')->nullable();
            $table->string('website')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
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
        Schema::dropIfExists('admins');
    }
}
