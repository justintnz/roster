<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->unsignedInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->unsignedInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
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
        Schema::dropIfExists('shifts');
    }
}
