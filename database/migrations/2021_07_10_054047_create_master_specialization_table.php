<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterSpecializationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_specialization', function (Blueprint $table) {
            $table->integer('SpId', true);
            $table->integer('EducationId');
            $table->string('Specialization', 200);
            $table->string('Status', 1)->default('A');
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
        Schema::dropIfExists('master_specialization');
    }
}
