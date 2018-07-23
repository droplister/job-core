<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingOccupationalSeriesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_occupational_series', function (Blueprint $table) {
            // Relations
            $table->integer('listing_id')->unsigned()->index();
            $table->integer('occupational_series_id')->unsigned()->index();

            // Foreign Keys
            $table->foreign('listing_id')->references('id')->on('listings');
            $table->foreign('occupational_series_id')->references('id')->on('occupational_series');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listing_occupational_series');
    }
}
