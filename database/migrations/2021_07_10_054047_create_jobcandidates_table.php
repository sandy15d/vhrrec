<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobcandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobcandidates', function (Blueprint $table) {
            $table->integer('JCId', true);
            $table->string('RollNo', 20);
            $table->string('NameTitle', 10);
            $table->string('FName', 30);
            $table->string('MName', 30);
            $table->string('LName', 30);
            $table->date('DOB');
            $table->string('Gender', 1);
            $table->string('nationality', 200);
            $table->string('religion', 200);
            $table->string('other_religion', 200);
            $table->string('Caste', 30);
            $table->string('OtherCaste', 100);
            $table->integer('State');
            $table->integer('Dist');
            $table->string('City', 100);
            $table->integer('PinCode');
            $table->string('MaritalStatus', 20);
            $table->string('marriage_dt', 10)->nullable();
            $table->string('FatherName', 100);
            $table->string('Aadhar', 20);
            $table->string('Email1', 200);
            $table->string('Email2', 200);
            $table->string('Password', 200);
            $table->string('Contact1', 20);
            $table->string('Contact2', 20);
            $table->string('ProfessOrFresher', 1);
            $table->integer('College');
            $table->string('OtherCollege', 200);
            $table->string('WorkExpYears', 100);
            $table->string('WorkExpMonths', 10);
            $table->string('CurCompany', 200);
            $table->string('CurJobTitle', 200);
            $table->string('CurDepartment', 200);
            $table->string('CurDesignation', 200);
            $table->date('JobStartDate');
            $table->date('JobEndDate');
            $table->string('StillEmployed', 1);
            $table->string('GMonthlySalary', 100);
            $table->string('AnnualCTC', 100);
            $table->string('OtherBenefits', 5000);
            $table->string('CurLocation', 200);
            $table->string('PrevInterviewed', 1);
            $table->date('PrevInterviewedDate');
            $table->string('PrevInterviewedPosition', 400);
            $table->string('CandidateImg', 50);
            $table->string('Resume', 50);
            $table->string('Address', 1000);
            $table->string('RefName', 200);
            $table->string('RefCompany', 500);
            $table->string('RefDesignatin', 500);
            $table->string('RefContact', 20);
            $table->string('RefEmail', 200);
            $table->string('DrivingLicense', 40);
            $table->date('LValidity');
            $table->string('Verified', 1)->default('N');
            $table->integer('EmailOTP');
            $table->integer('SMSOTP');
            $table->string('PerM_Salary', 100);
            $table->string('PreA_CTC', 100);
            $table->string('DAHq', 11);
            $table->string('DAOut', 11);
            $table->string('PetrolAlw', 11);
            $table->string('PhoneAlw', 11);
            $table->string('HotelElg', 11);
            $table->string('ExpCTC', 11);
            $table->string('NoticePeriod', 60);
            $table->tinyInteger('InterviewSubmit')->default(0);
            $table->tinyInteger('FinalSubmit')->default(0);
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
        Schema::dropIfExists('jobcandidates');
    }
}
