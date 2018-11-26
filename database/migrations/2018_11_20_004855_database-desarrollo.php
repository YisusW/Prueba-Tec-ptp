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
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('country');
        });

        // tabla city
        Schema::create('city', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->unsignedInteger('state_id');
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on('state');
        });

        // tabla type_roll
        Schema::create('type_person', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->boolean('status');
            $table->timestamps();
        });

        // tabla persona
        Schema::create('person', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('type_person_id');
            $table->string('document');
            $table->string('document_type');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('email');
            $table->string('phone');
            $table->string('cell_phone');
            $table->string('company');
            $table->timestamps();
            $table->foreign('city_id')->references('id')->on('city');
            $table->foreign('type_person_id')->references('id')->on('type_person');
        });

        // tabla bank
        Schema::create('type_client', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->boolean('status');
            $table->timestamps();
        });

        // tabla bank
        Schema::create('bank', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method_pay');
            $table->string('code_bank');
            $table->unsignedInteger('type_client_id');
            $table->double('money');
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('type_client_id')->references('id')->on('type_client');
        });
        /* table transaction or data response of soap Place to pay */
        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payer_id');
            $table->unsignedInteger('buyer_id');
            $table->unsignedInteger('bank_id');
            $table->string('transaction_id');
            $table->string('session_id');
            $table->string('trazability_code');
            $table->string('status');
            $table->timestamps();
            $table->foreign('payer_id')->references('id')->on('person');
            $table->foreign('buyer_id')->references('id')->on('person');
            $table->foreign('bank_id')->references('id')->on('bank');
        });
        $this->register();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaction');
        Schema::drop('bank');
        Schema::drop('type_client');
        Schema::drop('person');
        Schema::drop('type_person');
        Schema::drop('city');
        Schema::drop('state');
        schema::drop('country');
    }

    /**
     *
     *  Function que retorna los registros para los modulos necesarios (básicos)
     *  @return rows
     */
    private function register()
    {
         \DB::table('country')->insert(array(
                'description'  => 'Colombia',
                'status' => 1
         ));
         \DB::table('state')->insert(array(
                'description'  => 'Antioquia',
                'country_id' => 1,
                'status' => 1
         ));
         \DB::table('city')->insert(array(
                'description'  => 'Medellin',
                'state_id' => 1,
                'status' => 1
         ));
         $one = array(
                 'description'  => 'Natural',
                 'status' => 1
               );
         $two = array(
                       'description'  => 'Juridica',
                       'status' => 1
               );
         \DB::table('type_person')->insert($one);
         \DB::table('type_person')->insert($two);
         /* save the first type_client */
         $one = array(
                   'description'  => 'Persona',
                   'status' => 1
               );
         $two = array(
                   'description'  => 'Empresa',
                   'status' => 1
               );
         \DB::table('type_client')->insert($one);
         \DB::table('type_client')->insert($two);
    }

}
