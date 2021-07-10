<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferletterbasicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offerletterbasic', function (Blueprint $table) {
            $table->integer('OfLeId', true);
            $table->integer('JAId');
            $table->integer('Company');
            $table->integer('Grade');
            $table->integer('Department');
            $table->integer('Designation');
            $table->tinyInteger('TempS')->default(0);
            $table->string('T_StateHq', 5)->comment('Temporary');
            $table->string('T_LocationHq', 5)->comment('Temporary');
            $table->string('TempM', 60);
            $table->tinyInteger('FixedS')->default(0);
            $table->string('F_StateHq', 11)->comment('Fixed');
            $table->string('F_LocationHq', 11)->comment('Fixed');
            $table->tinyInteger('Functional_R')->default(0);
            $table->integer('Functional_Dpt')->comment('Functional Reporting Department');
            $table->string('F_ReportingManager', 5)->comment('Functional | EmployeeID');
            $table->tinyInteger('Admins_R')->default(0);
            $table->integer('Admins_Dpt')->comment('Administrative Reporting Department');
            $table->string('A_ReportingManager', 5)->comment('Administrative | EmployeeID');
            $table->string('CTC', 100);
            $table->string('ServiceCondition', 500);
            $table->string('OrientationPeriod', 11);
            $table->string('Stipend', 60);
            $table->integer('AFT_Grade')->comment('After Training Grade');
            $table->integer('AFT_Designation')->comment('After Training Designation');
            $table->string('ServiceBond', 500);
            $table->string('ServiceBondYears', 200);
            $table->string('ServiceBondRefund', 10);
            $table->string('PreMedicalCheckUp', 500);
            $table->string('Remarks', 1000);
            $table->text('OfferLetter');
            $table->text('CompDetails');
            $table->text('EligDetails');
            $table->tinyInteger('OfferLtrGen')->default(0);
            $table->string('OfferLetterSent', 10);
            $table->string('JoiningFormSent', 10);
            $table->string('Answer', 50);
            $table->string('RejReason', 500);
            $table->tinyInteger('Reopen')->default(0);
            $table->tinyInteger('SendReview')->default(0);
            $table->string('ReviewerMail', 60);
            $table->string('ReviewStatus', 10);
            $table->string('ReviewRejReason', 5000);
            $table->tinyInteger('SendForRefChk')->default(0);
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
        Schema::dropIfExists('offerletterbasic');
    }
}
