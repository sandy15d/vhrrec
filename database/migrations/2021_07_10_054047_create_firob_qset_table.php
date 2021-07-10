<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirobQsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firob_qset', function (Blueprint $table) {
            $table->integer('FirobQSetId', true);
            $table->char('FiroSetN', 2);
            $table->integer('q1');
            $table->integer('q2');
            $table->integer('q3');
            $table->integer('q4');
            $table->integer('q5');
            $table->integer('q6');
            $table->integer('q7');
            $table->integer('q8');
            $table->integer('q9');
            $table->integer('q10');
            $table->string('q1a', 500);
            $table->string('q2a', 500);
            $table->string('q3a', 500);
            $table->string('q4a', 500);
            $table->string('q5a', 500);
            $table->string('q6a', 500);
            $table->string('q7a', 500);
            $table->string('q8a', 500);
            $table->string('q9a', 500);
            $table->string('q10a', 500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firob_qset');
    }
}
