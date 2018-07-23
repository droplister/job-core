<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgencySubElementListingPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_agency_sub_element', function (Blueprint $table) {
            // Relations
            $table->integer('listing_id')->unsigned()->index();
            $table->integer('agency_sub_element_id')->unsigned()->index();

            // Foreign Keys
            $table->foreign('listing_id')->references('id')->on('listings');
            $table->foreign('agency_sub_element_id')->references('id')->on('agency_sub_elements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listing_agency_sub_element');
    }
}
