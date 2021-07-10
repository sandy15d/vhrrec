<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJfReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jf_reference', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('JCId');
            $table->string('from', 100);
            $table->string('name', 200);
            $table->string('company', 200);
            $table->string('designation', 200);
            $table->string('email', 200);
            $table->string('contact', 10);
            $table->string('rel_with_person', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jf_reference');
    }
}
