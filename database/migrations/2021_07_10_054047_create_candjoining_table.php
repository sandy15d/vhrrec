<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandjoiningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candjoining', function (Blueprint $table) {
            $table->integer('CJId', true);
            $table->integer('JAId');
            $table->date('LinkValidityStart');
            $table->date('LinkValidityEnd');
            $table->string('LinkStatus', 20);
            $table->date('JoinOnDt');
            $table->string('FailingWhi', 100);
            $table->string('Place', 100);
            $table->date('Date');
            $table->string('Signature', 500);
            $table->string('Answer', 50);
            $table->string('RejReason', 1000);
            $table->string('Aadhar', 200);
            $table->string('PanCard', 200);
            $table->string('BankDoc', 200);
            $table->string('RefCheck', 10)->default('No');
            $table->string('PositionCode', 60);
            $table->string('EmpCode', 10);
            $table->string('Verification', 20)->default('Not Verified');
            $table->string('ForwardToESS', 20);
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
        Schema::dropIfExists('candjoining');
    }
}
