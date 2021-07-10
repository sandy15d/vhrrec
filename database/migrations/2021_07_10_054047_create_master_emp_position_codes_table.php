<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterEmpPositionCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_emp_position_codes', function (Blueprint $table) {
            $table->integer('EmPosCodeID', true);
            $table->integer('EmpCode');
            $table->integer('CompanyId');
            $table->integer('GradeId');
            $table->integer('DepartmentId');
            $table->integer('DesigId')->default(0);
            $table->string('PositionCode', 100);
            $table->integer('PositionSequence');
            $table->dateTime('LastUpdated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_emp_position_codes');
    }
}
