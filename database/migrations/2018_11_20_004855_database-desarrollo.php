<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatabaseDesarrollo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // tabla country
        Schema::create('country', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->boolean('status');
            $table->timestamps();
        });
        // tabla state
        Schema::create('state', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->unsignedInteger('country_id');
            $table->foreign('country_id')->references('id')->on('country');
            $table->boolean('status');
            $table->timestamps();
        });
        // tabla state
        Schema::create('city', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->unsignedInteger('state_id');
            $table->foreign('state_id')->references('id')->on('state');
            $table->boolean('status');
            $table->timestamps();
        });
        // tabla persona
        Schema::create('person', function (Blueprint $table) {
            $table->increments('id');
            $table->string('document');
            $table->string('documentType');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('address');
            $table->string('emailAddress');
            $table->unsignedInteger('city_id');
            $table->foreign('city_id')->references('id')->on('city');
            $table->string('phone');
            $table->string('mobile');
            $table->timestamps();
        });
        // tabla type_roll
        Schema::create('type_roll', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->boolean('status');
            $table->timestamps();
        });

        // tabla person_type_roll
        Schema::create('person_type_roll', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('person_id');
            $table->foreign('person_id')->references('id')->on('person');
            $table->unsignedInteger('type_roll_id');
            $table->foreign('type_roll_id')->references('id')->on('type_roll');
            $table->boolean('status');
            $table->timestamps();
        });

        // tabla person_type_roll
        Schema::create('bank', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method_pay');
            $table->string('type_person');
            $table->string('code_bank');
            $table->boolean('status');
            $table->timestamps();
        });

        // tabla person_type_roll
        Schema::create('banck_person', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('bank');
            $table->unsignedInteger('person_roll_id');
            $table->foreign('person_roll_id')->references('id')->on('person_type_roll');
            $table->boolean('status');
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
        //
    }
}
