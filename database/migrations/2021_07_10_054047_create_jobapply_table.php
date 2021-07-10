<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobapplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobapply', function (Blueprint $table) {
            $table->integer('JAId', true);
            $table->integer('JCId');
            $table->integer('JPId');
            $table->string('Type', 50);
            $table->integer('ResumeSouId');
            $table->integer('DepartmentId');
            $table->string('Message', 5000);
            $table->string('KeyPositionCriteria', 4000);
            $table->string('GroupDiscussion', 1);
            $table->string('Status', 30);
            $table->integer('SelectedBy');
            $table->integer('InterviewedBy');
            $table->string('AssessmentSheet', 50);
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
        Schema::dropIfExists('jobapply');
    }
}
