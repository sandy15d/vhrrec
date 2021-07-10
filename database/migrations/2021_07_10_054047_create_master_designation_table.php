<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterDesignationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_designation', function (Blueprint $table) {
            $table->integer('DesigId', true);
            $table->string('DesigName', 50);
            $table->string('DesigCode', 50);
            $table->integer('DepartmentId');
            $table->integer('CompanyId');
            $table->char('DesigStatus', 2)->default('A')->comment('A-active,D-deactive,De-delete');
            $table->integer('CreatedBy')->default(0)->comment('AXAUESRUser_Id');
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
        Schema::dropIfExists('master_designation');
    }
}
