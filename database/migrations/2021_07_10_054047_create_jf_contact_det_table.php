<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJfContactDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jf_contact_det', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('JCId');
            $table->string('perm_address', 2000);
            $table->integer('perm_state');
            $table->integer('perm_dist');
            $table->string('perm_city', 30);
            $table->integer('perm_pin');
            $table->string('pre_address', 2000);
            $table->integer('pre_state');
            $table->integer('pre_dist');
            $table->string('pre_city', 30);
            $table->integer('pre_pin');
            $table->string('cont_one_name', 500);
            $table->string('cont_one_relation', 500);
            $table->string('cont_one_number', 10);
            $table->string('cont_two_name', 500);
            $table->string('cont_two_relation', 500);
            $table->string('cont_two_number', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jf_contact_det');
    }
}
