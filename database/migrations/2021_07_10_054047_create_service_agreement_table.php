<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAgreementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_agreement', function (Blueprint $table) {
            $table->integer('AId', true);
            $table->string('ServAgr', 10);
            $table->integer('JAId');
            $table->date('A_Date');
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
        Schema::dropIfExists('service_agreement');
    }
}
