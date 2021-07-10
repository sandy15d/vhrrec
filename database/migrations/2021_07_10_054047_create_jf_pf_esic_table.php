<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJfPfEsicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jf_pf_esic', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('JCId');
            $table->string('prof_fresher', 20);
            $table->string('UAN', 100);
            $table->string('pf_acc_no', 100);
            $table->string('esic_no', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jf_pf_esic');
    }
}
