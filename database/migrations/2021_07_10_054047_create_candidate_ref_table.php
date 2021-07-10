<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateRefTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_ref', function (Blueprint $table) {
            $table->integer('REFId', true);
            $table->integer('JAId');
            $table->string('Company', 5000);
            $table->date('FromDate');
            $table->date('ToDate');
            $table->string('Designation', 5000);
            $table->string('ReportMgr', 60);
            $table->string('EmpType', 20);
            $table->string('Agency', 500);
            $table->string('NetMonth', 20);
            $table->string('CTC', 20);
            $table->string('AbilityTeam', 20);
            $table->string('Loyal', 20);
            $table->string('Leadership', 20);
            $table->string('Relationship', 20);
            $table->string('CharacterConduct', 20);
            $table->text('Strength');
            $table->text('Weakness');
            $table->text('LeaveReason');
            $table->text('Rehire');
            $table->text('AnyOther');
            $table->string('VerifierName', 60);
            $table->string('VDesig', 100);
            $table->string('Contact', 13);
            $table->string('Email', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_ref');
    }
}
