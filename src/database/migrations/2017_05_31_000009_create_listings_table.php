<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('control_number')->unique();
            $table->string('position_id')->index();
            $table->string('organization_code')->nullable()->index();
            $table->string('department_code')->nullable()->index();
            $table->string('position_title');
            $table->string('slug')->unique();
            $table->string('position_uri');
            $table->string('position_location_display');
            $table->string('position_schedule');
            $table->string('position_schedule_code')->index();
            $table->string('rate_interval_code')->index();
            $table->string('who_may_apply_code')->index();
            $table->string('job_grade_code')->index();
            $table->string('low_grade')->index();
            $table->string('high_grade')->index();
            $table->text('position_offering_type');
            $table->text('qualification_summary');
            $table->text('job_summary');
            $table->text('who_may_apply');
            $table->decimal('minimum_range');
            $table->decimal('maximum_range');
            $table->integer('position_offering_type_code')->index();
            $table->integer('clearance_code')->index()->default(0);
            $table->integer('travel_percentage_code')->index()->default(0);
            $table->boolean('military_base_flag')->default(0);
            $table->boolean('internship_flag')->default(0);
            $table->boolean('clearance_flag')->default(0);
            $table->date('position_start_date')->index();
            $table->date('position_end_date')->index();
            $table->date('publication_start_date')->index();
            $table->date('application_close_date')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listings');
    }
}