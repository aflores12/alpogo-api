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
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->text('description');
            $table->string('cover_image');
            $table->string('start_date');
            $table->string('end_date');
            $table->integer('age_restriction')->nullable();
            $table->string('locale');
            $table->string('location');
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
        Schema::drop('events');
    }
}
