<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJfLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jf_language', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('JCId');
            $table->string('language', 200);
            $table->integer('read')->default(0);
            $table->integer('write')->default(0);
            $table->integer('speak')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jf_language');
    }
}
