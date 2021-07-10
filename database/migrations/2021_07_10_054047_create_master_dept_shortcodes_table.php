<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterDeptShortcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_dept_shortcodes', function (Blueprint $table) {
            $table->integer('DeptShortId', true);
            $table->integer('DepartmentId');
            $table->string('ShortCode', 100)->nullable();
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
        Schema::dropIfExists('master_dept_shortcodes');
    }
}
