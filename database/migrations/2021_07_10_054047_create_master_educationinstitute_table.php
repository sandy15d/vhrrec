<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterEducationinstituteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_educationinstitute', function (Blueprint $table) {
            $table->integer('EducationInsId', true);
            $table->string('EducationIns', 200);
            $table->string('EducationInsCode', 10);
            $table->integer('StateId');
            $table->integer('DistrictId');
            $table->string('Category', 300);
            $table->string('Type', 300);
            $table->dateTime('CreatedTime');
            $table->integer('CreatedBy');
            $table->dateTime('LastUpdated');
            $table->integer('UpdatedBy');
            $table->integer('IsDeleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_educationinstitute');
    }
}
