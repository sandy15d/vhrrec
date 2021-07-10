<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManpowerrequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manpowerrequisition', function (Blueprint $table) {
            $table->integer('MRFId', true);
            $table->string('JobCode', 500);
            $table->string('PositionCode', 200);
            $table->string('Type', 20);
            $table->integer('RepEmployeeID')->comment('EmployeeID');
            $table->string('Reason', 1000);
            $table->integer('CompanyId');
            $table->integer('DepartmentId');
            $table->integer('DesigId');
            $table->integer('GradeId');
            $table->integer('Positions');
            $table->string('LocationIds', 500);
            $table->integer('Reporting');
            $table->bigInteger('ExistCTC');
            $table->bigInteger('MinCTC');
            $table->bigInteger('MaxCTC');
            $table->string('WorkExp', 400);
            $table->string('Remarks', 1000);
            $table->text('Info');
            $table->string('EducationId', 500);
            $table->text('EducationInsId');
            $table->string('KeyPositionCriteria', 4000);
            $table->string('KPC', 4000);
            $table->string('Status', 200);
            $table->text('RemarkHr');
            $table->integer('Allocated');
            $table->date('AllocatedDt');
            $table->date('CloseDt');
            $table->integer('OnBehalf');
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
        Schema::dropIfExists('manpowerrequisition');
    }
}
