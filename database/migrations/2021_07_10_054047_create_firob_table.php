<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firob', function (Blueprint $table) {
            $table->integer('FirobId', true);
            $table->string('FiroE', 200);
            $table->string('FiroH', 200)->default('');
            $table->integer('FiroO');
            $table->char('FiroF', 1);
            $table->char('FiroSts', 2)->default('A');
            $table->integer('ns1');
            $table->integer('ns2');
            $table->integer('ns3');
            $table->integer('ns4');
            $table->integer('ns5');
            $table->integer('FiroCre');
            $table->date('FiroCreDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firob');
    }
}
