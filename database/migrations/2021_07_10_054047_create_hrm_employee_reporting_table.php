<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmEmployeeReportingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_employee_reporting', function (Blueprint $table) {
            $table->integer('ReportingId')->primary();
            $table->integer('EmployeeID');
            $table->integer('AppraiserId');
            $table->integer('ReviewerId');
            $table->integer('HodId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrm_employee_reporting');
    }
}
