<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateCtcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_ctc', function (Blueprint $table) {
            $table->integer('CTCId', true);
            $table->integer('JAId');
            $table->string('ctcLetterNo', 30);
            $table->date('ctc_date');
            $table->string('basic', 7);
            $table->string('hra', 7);
            $table->string('bonus', 7);
            $table->string('special_alw', 7);
            $table->string('grsM_salary', 7);
            $table->string('emplyPF', 7);
            $table->string('emplyESIC', 7);
            $table->string('netMonth', 7);
            $table->string('lta', 7);
            $table->string('childedu', 7);
            $table->string('anualgrs', 7);
            $table->string('gratuity', 7);
            $table->string('emplyerPF', 7);
            $table->string('emplyerESIC', 7);
            $table->string('medical', 7);
            $table->string('total_ctc', 10);
            $table->dateTime('created_on')->useCurrent();
            $table->integer('created_by');
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_ctc');
    }
}
