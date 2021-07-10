<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreviousScreeningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previous_screening', function (Blueprint $table) {
            $table->integer('PSCId', true);
            $table->integer('JAId');
            $table->date('ReSentForScreen');
            $table->integer('ScrCmp');
            $table->integer('ScrDpt');
            $table->integer('ScreeningBy');
            $table->dateTime('CreatedTime');
            $table->integer('CreatedBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('previous_screening');
    }
}
