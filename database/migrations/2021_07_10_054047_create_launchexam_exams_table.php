<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaunchexamExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('launchexam_exams', function (Blueprint $table) {
            $table->integer('LEEId', true);
            $table->integer('ExamId');
            $table->integer('TestPaperId');
            $table->integer('TotalExamTime');
            $table->string('NegativeMarking', 1);
            $table->integer('EnterNegativeMarks');
            $table->string('EachQuestionTime', 1);
            $table->integer('EnterTime');
            $table->string('ShuffleQuestion', 1);
            $table->string('ShuffleAnswers', 1);
            $table->string('QuestionNavigation', 1);
            $table->integer('TimeRemainder');
            $table->integer('MaxWinSwitchAlerts');
            $table->text('Instructions');
            $table->string('Status', 100)->default('Not Started');
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
        Schema::dropIfExists('launchexam_exams');
    }
}
