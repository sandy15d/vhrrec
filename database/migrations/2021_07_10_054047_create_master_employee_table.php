<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_employee', function (Blueprint $table) {
            $table->integer('EmployeeID')->primary();
            $table->integer('EmpCode');
            $table->char('EmpType', 1)->nullable()->default('E');
            $table->char('EmpStatus', 2)->default('A')->comment('A-actve,D-delete,De-deactive');
            $table->string('Title', 10);
            $table->string('Fname', 30);
            $table->string('Sname', 25);
            $table->string('Lname', 25);
            $table->integer('CompanyId');
            $table->integer('GradeId');
            $table->integer('DepartmentId');
            $table->integer('DesigId')->default(0);
            $table->integer('RepEmployeeID');
            $table->string('Contact', 20);
            $table->string('Email', 200);
            $table->string('Gender', 1);
            $table->string('Married', 4);
            $table->string('DR', 4);
            $table->integer('Location');
            $table->date('DOJ');
            $table->date('DateOfSepration');
            $table->decimal('CTC', 10, 0);
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
        Schema::dropIfExists('master_employee');
    }
}
