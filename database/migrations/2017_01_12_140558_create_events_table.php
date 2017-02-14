<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {

            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->text('short_description');
            $table->text('description');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('locale');
            $table->string('location');
            $table->timestamps();

            /**
             * Evento
             *
             * Titulo
             * imagen de portada
             * descripción corta
             * descripción larga
             * fecha de inicio (fecha y hora)
             * fecha de fin (fecha y hora)
             * Locación (espacio físico donde se hace el evento)
             * Lugar (ciudad, provincia, pais)
             * Preguntas frecuentes
             * Organizador de evento
             * productores
             *
             */

            /**
             * Tipo de evento
             *
             * titulo
             * descripción
             * imagen
             *
             */

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

            /**
             * Sorteos
             *
             * nombre
             * tipo de item
             * cantidad
             * fecha y hora
             *
             */

            /**
             * Tipo de item
             *
             * nombre
             * descripcion
             *
             */

            /**
             * Promociones
             *
             * nombre
             * cantidad
             * valor
             * activo (boolean)
             * tipo de promocion
             *
             */

            /**
             * Tipo promocion
             *
             * nombre
             * descricpion
             *
             */

            /**
             * Mensajes
             */

            /**
             * Merchan
             *
             * nombre
             * descripcion
             * precio
             * stock
             *
             */

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
