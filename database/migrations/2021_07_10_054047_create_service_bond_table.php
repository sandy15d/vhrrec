<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_bond', function (Blueprint $table) {
            $table->integer('BId', true);
            $table->integer('JAId');
            $table->date('B_Date');
            $table->string('ServBond', 4);
            $table->dateTime('CreateTime')->useCurrent();
            $table->integer('CreatedBy');
            $table->dateTime('LastUpdateTime');
            $table->integer('LastUpdateBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_bond');
    }
}
