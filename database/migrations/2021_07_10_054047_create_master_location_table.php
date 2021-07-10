<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_location', function (Blueprint $table) {
            $table->integer('LocationId', true);
            $table->string('Location', 200);
            $table->string('LocationCode', 50);
            $table->string('LocationAddress', 500);
            $table->integer('CountryId');
            $table->integer('StateId');
            $table->integer('DistrictId');
            $table->integer('CityId');
            $table->string('Status', 10);
            $table->dateTime('CreatedTime');
            $table->integer('CreatedBy');
            $table->dateTime('LastUpdated');
            $table->integer('UpdatedBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_location');
    }
}
