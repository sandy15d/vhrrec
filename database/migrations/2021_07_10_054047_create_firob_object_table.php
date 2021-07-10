<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirobObjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firob_object', function (Blueprint $table) {
            $table->integer('FirobOId', true);
            $table->char('FiroF', 1);
            $table->string('h1', 30)->default('');
            $table->string('e1', 30)->default('');
            $table->string('h2', 30)->default('');
            $table->string('e2', 30)->default('');
            $table->string('h3', 30)->default('');
            $table->string('e3', 30)->default('');
            $table->string('h4', 30)->default('');
            $table->string('e4', 30)->default('');
            $table->string('h5', 30)->default('');
            $table->string('e5', 30)->default('');
            $table->string('h6', 30)->default('');
            $table->string('e6', 30)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firob_object');
    }
}
