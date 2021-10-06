<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->unsignedBigInteger('unit_id');

            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('password');
            $table->string('fb_address')->nullable();
            $table->string('designation')->nullable();
            $table->string('office_name')->nullable();
            $table->string('office_address')->nullable();
            $table->string('api_token')->nullable();
            $table->string('verify_token')->nullable();
            $table->enum('language', ['en', 'bn']);
            $table->string('remember_token')->nullable();
            $table->string('birthdate')->nullable();
            $table->integer('status')->default(0);
            $table->integer('total_reward_point')->default(0);

            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('upazilla_id')->nullable();

            $table->unsignedBigInteger('contact_type_id');

            $table->foreign('contact_type_id')->references('id')->on('contact_types')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('upazilla_id')->references('id')->on('upazilas')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
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
        Schema::dropIfExists('contacts');
    }
}
