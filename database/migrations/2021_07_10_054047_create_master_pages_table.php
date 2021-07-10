<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_pages', function (Blueprint $table) {
            $table->integer('pid', true);
            $table->string('pageName', 200);
            $table->string('page', 200);
            $table->string('pageParent', 200);
            $table->integer('pageSequence');
            $table->string('status', 1)->default('A');
            $table->string('pageFor', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_pages');
    }
}
