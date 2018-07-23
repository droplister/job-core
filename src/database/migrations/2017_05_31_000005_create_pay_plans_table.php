<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_plans', function (Blueprint $table) {
            $table->increments('id');

            // PayPlans
            $table->string('code')->unique();
            $table->string('slug')->unique();
            $table->string('value');
            $table->boolean('disabled')->index();
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
        Schema::dropIfExists('pay_plans');
    }
}
