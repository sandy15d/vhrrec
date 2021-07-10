<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJfWorkExpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jf_work_exp', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('JCId');
            $table->string('company', 500);
            $table->string('desgination', 500);
            $table->date('job_start');
            $table->date('job_end');
            $table->string('still_emp', 1);
            $table->string('gross_mon_sal', 50);
            $table->string('annual_ctc', 50);
            $table->string('reason_fr_leaving', 2000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jf_work_exp');
    }
}
