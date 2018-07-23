<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingHiringPathTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_hiring_path', function (Blueprint $table) {
            // Relations
            $table->integer('listing_id')->unsigned()->index();
            $table->integer('hiring_path_id')->unsigned()->index();

            // Foreign Keys
            $table->foreign('listing_id')->references('id')->on('listings');
            $table->foreign('hiring_path_id')->references('id')->on('hiring_paths');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listing_hiring_path');
    }
}
