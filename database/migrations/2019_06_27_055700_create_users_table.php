<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('api_token')->unique();
            $table->string('phone_no')->unique();
            $table->string('website')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->date('date_of_birth')->nullable();
            $table->unsignedBigInteger('job_level_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('cv')->nullable()->comment('Job Seeker CV file');
            
            $table->foreign('job_level_id')->references('id')->on('job_levels')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
