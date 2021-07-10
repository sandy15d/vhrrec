<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirobUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firob_user', function (Blueprint $table) {
            $table->integer('FirobUId', true);
            $table->integer('userid');
            $table->integer('FirobId');
            $table->integer('FirobUVal')->default(0);
            $table->char('SubSts', 1)->default('N')->comment('N-No, Y-Yse');
            $table->date('SubDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firob_user');
    }
}
