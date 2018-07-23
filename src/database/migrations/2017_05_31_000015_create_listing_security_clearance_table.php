<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingSecurityClearanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_security_clearance', function (Blueprint $table) {
            // Relations
            $table->integer('listing_id')->unsigned()->index();
            $table->integer('security_clearance_id')->unsigned()->index();

            // Foreign Keys
            $table->foreign('listing_id')->references('id')->on('listings');
            $table->foreign('security_clearance_id')->references('id')->on('security_clearances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listing_security_clearance');
    }
}
