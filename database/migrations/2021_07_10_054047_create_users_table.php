<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('uId', 11)->primary();
            $table->string('uName', 200);
            $table->string('uUsername', 200);
            $table->string('uPassword', 200);
            $table->string('uType', 1)->comment('S=Super Admin, U=User, P=Production Person, H = HOD');
            $table->string('uContact', 10);
            $table->string('uEmail', 200);
            $table->string('uPost', 10);
            $table->string('uReporting', 10);
            $table->string('uStatus', 1);
            $table->integer('uShow')->default(1);
            $table->tinyInteger('IsDeleted')->default(0);
            $table->string('uCrby', 11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
