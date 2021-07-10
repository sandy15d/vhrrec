<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamattemptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examattempt', function (Blueprint $table) {
            $table->integer('AttemptId', true);
            $table->integer('JCId');
            $table->integer('ExamId');
            $table->integer('LEEId');
            $table->dateTime('ExamStart');
            $table->dateTime('ExamEnd');
            $table->time('TimePassed');
            $table->string('Answers', 10000);
            $table->text('SAnswer');
            $table->integer('Score');
            $table->string('Status', 10);
            $table->string('ExamOverReason', 100);
            $table->tinyInteger('AnsChecked')->default(0);
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
        Schema::dropIfExists('examattempt');
    }
}
