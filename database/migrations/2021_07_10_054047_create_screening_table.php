<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreeningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screening', function (Blueprint $table) {
            $table->integer('ScId', true);
            $table->integer('JAId');
            $table->date('ReSentForScreen');
            $table->integer('ScrCmp');
            $table->integer('ScrDpt');
            $table->string('ScreeningBy', 200);
            $table->date('ResScreened');
            $table->string('ScreenStatus', 100);
            $table->integer('SueDept1');
            $table->integer('SueDept2');
            $table->integer('SueDept3');
            $table->string('RejectionRem', 1000);
            $table->string('SendInterMail', 10);
            $table->string('InterAtt', 10);
            $table->date('IntervDt');
            $table->time('IntervTime');
            $table->string('IntervLoc', 500);
            $table->string('IntervPanel', 500);
            $table->string('travelEligibility', 300);
            $table->string('IntervStatus', 100);
            $table->integer('SelectedForC');
            $table->integer('SelectedForD');
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
        Schema::dropIfExists('screening');
    }
}
