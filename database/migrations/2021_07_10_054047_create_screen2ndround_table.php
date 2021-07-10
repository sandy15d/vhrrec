<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreen2ndroundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screen2ndround', function (Blueprint $table) {
            $table->integer('SScId', true);
            $table->integer('ScId');
            $table->string('InterAtt2', 10);
            $table->date('IntervDt2');
            $table->string('IntervLoc2', 500);
            $table->string('IntervPanel2', 500);
            $table->string('IntervStatus2', 100);
            $table->string('Remarks', 1000);
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
        Schema::dropIfExists('screen2ndround');
    }
}
