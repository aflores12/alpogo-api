<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tickets', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->integer('stock');
            $table->integer('amount');
            $table->integer('producer_amount');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('event_id')->nullable();

        });

        /**
         * Entradas
         *
         * nomnbre de entrada
         * Stock
         * precio final
         * fecha de inicio de venta
         * fecha fin de venta
         * restriccion de edad
         *
         *
         */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tickets');
    }
}
