<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->integer('QId', true);
            $table->integer('QPId');
            $table->string('Type', 20);
            $table->text('Question');
            $table->text('OptionA');
            $table->text('OptionB');
            $table->text('OptionC');
            $table->text('OptionD');
            $table->text('CorrectAns');
            $table->text('AttachImg');
            $table->integer('QOrder');
            $table->string('Status', 20);
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
        Schema::dropIfExists('questions');
    }
}
