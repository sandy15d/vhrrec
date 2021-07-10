<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeypostioncriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keypostioncriteria', function (Blueprint $table) {
            $table->integer('KPCId', true);
            $table->string('KeyPostionCriteria', 500);
            $table->integer('MRFId');
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
        Schema::dropIfExists('keypostioncriteria');
    }
}
