<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraineeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainee_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 500);
            $table->string('university', 500);
            $table->string('qualification', 500);
            $table->integer('specialization');
            $table->date('doj');
            $table->date('doc')->nullable()->comment('date of completion');
            $table->integer('reporting');
            $table->integer('location');
            $table->integer('department');
            $table->string('gender', 10);
            $table->integer('stipend');
            $table->string('expdata', 2000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainee_details');
    }
}
