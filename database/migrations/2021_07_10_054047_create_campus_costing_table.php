<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampusCostingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campus_costing', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('JPId');
            $table->string('university', 500);
            $table->date('fromdt');
            $table->date('todt');
            $table->integer('appeared');
            $table->integer('hired');
            $table->string('avg_cost', 6);
            $table->integer('RT1')->default(0);
            $table->integer('RT2')->default(0);
            $table->integer('RT3')->default(0);
            $table->integer('RT4')->default(0);
            $table->integer('total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campus_costing');
    }
}
