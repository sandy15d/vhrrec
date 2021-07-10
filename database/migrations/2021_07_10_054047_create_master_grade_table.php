<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_grade', function (Blueprint $table) {
            $table->integer('GradeId', true);
            $table->string('GradeValue', 12)->nullable();
            $table->integer('CompanyId');
            $table->char('GradeStatus', 2)->default('A')->comment('A-active,D-deactive,De-delete');
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
        Schema::dropIfExists('master_grade');
    }
}
