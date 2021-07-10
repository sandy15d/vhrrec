<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_department', function (Blueprint $table) {
            $table->integer('DepartmentId', true);
            $table->string('DepartmentName', 50);
            $table->string('DepartmentCode', 20);
            $table->string('Comment', 100)->nullable();
            $table->integer('CompanyId');
            $table->char('DeptStatus', 2)->default('A')->comment('A-active,D-deactive,De-delete');
            $table->integer('CreatedBy')->comment('AXAUESRUser_Id');
            $table->date('CreatedDate');
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
        Schema::dropIfExists('master_department');
    }
}
