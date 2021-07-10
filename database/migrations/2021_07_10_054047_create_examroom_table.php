<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamroomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examroom', function (Blueprint $table) {
            $table->integer('RoomId', true);
            $table->string('RoomName', 200);
            $table->string('Status', 1);
            $table->tinyInteger('IsDelete')->default(0);
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
        Schema::dropIfExists('examroom');
    }
}
