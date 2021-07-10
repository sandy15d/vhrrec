<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobpostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobpost', function (Blueprint $table) {
            $table->integer('JPId', true);
            $table->integer('MRFId');
            $table->integer('CompanyId');
            $table->integer('DepartmentId');
            $table->integer('DesigId');
            $table->string('JobCode', 50);
            $table->string('Title', 300);
            $table->text('ReqQualification');
            $table->text('Description');
            $table->string('PayPackage', 200);
            $table->integer('State');
            $table->string('Location', 2000);
            $table->string('KeyPositionCriteria', 4000);
            $table->string('PostingView', 20);
            $table->string('Status', 20);
            $table->string('JobPostType', 30);
            $table->date('LastDate');
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
        Schema::dropIfExists('jobpost');
    }
}
