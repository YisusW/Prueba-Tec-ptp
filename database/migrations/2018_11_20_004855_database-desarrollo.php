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
            $table->string('cell_phone');
            $table->boolean('is_payer');
            $table->timestamps();
        });
        // tabla type_roll
        Schema::create('role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->boolean('status');
            $table->timestamps();
        });

        // tabla person_type_roll
        Schema::create('person_role', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('person_id');
            $table->foreign('person_id')->references('id')->on('person');
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')->references('id')->on('role');
            $table->boolean('status');
            $table->timestamps();
        });

        // tabla bank
        Schema::create('bank', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method_pay');
            $table->string('code_bank');
            $table->boolean('status');
            $table->timestamps();
        });

        // tabla bank_person
        Schema::create('bank_person', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('bank');
            $table->unsignedInteger('person_role_id');
            $table->foreign('person_role_id')->references('id')->on('person_role');
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
        Schema::drop('bank_person');
        Schema::drop('person_role');
        Schema::drop('role');
        Schema::drop('bank');
        Schema::drop('person');
        Schema::drop('city');
        Schema::drop('state');
        schema::drop('country');
    }
}
