<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJfDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jf_docs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('JCId');
            $table->string('Aadhar', 200);
            $table->string('PanCard', 200);
            $table->string('BankDoc', 200);
            $table->string('PF_Form2', 300);
            $table->string('PF_Form11', 300);
            $table->string('Gratutity', 300);
            $table->string('ESIC', 300);
            $table->string('ESIC_Family', 300);
            $table->string('Health', 300);
            $table->string('Ethical', 300);
            $table->string('DL', 200);
            $table->string('BloodGroup', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jf_docs');
    }
}
