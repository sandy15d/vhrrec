<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateeducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidateeducation', function (Blueprint $table) {
            $table->integer('CEId', true);
            $table->integer('JCId');
            $table->string('Qualification', 500);
            $table->string('Course', 500);
            $table->string('Specialization', 500);
            $table->string('Institute', 500);
            $table->string('YearOfPassing', 10);
            $table->string('CGPA', 10);
            $table->dateTime('CreatedTime');
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
        Schema::dropIfExists('candidateeducation');
    }
}
