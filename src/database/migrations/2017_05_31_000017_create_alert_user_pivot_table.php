<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_user', function (Blueprint $table) {
            // Relations
            $table->integer('alert_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->timestamp('expired_at');

            // Foreign Keys
            $table->foreign('alert_id')->references('id')->on('alerts');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alert_user');
    }
}
