<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');

            // Location
            $table->integer('parent_id')->nullable()->unsigned()->index();
            $table->string('type')->index();
            $table->string('name');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->text('description')->nullable();

            // Timestamps
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
        Schema::drop('locations');
    }
}