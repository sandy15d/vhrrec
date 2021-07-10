<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJfFamilyDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jf_family_det', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('JCId');
            $table->string('relation', 200);
            $table->string('name', 200);
            $table->date('dob');
            $table->string('qualification', 200);
            $table->string('occupation', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jf_family_det');
    }
}
