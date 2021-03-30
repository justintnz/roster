<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_location', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')
            ->references('id')
            ->on('role')->onDelete('cascade');
            $table->unsignedInteger('location_id');
            $table->foreign('location_id')
            ->references('id')
            ->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_location');
    }
}
