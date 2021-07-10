<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessdatatoessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processdatatoess', function (Blueprint $table) {
            $table->integer('Id', true);
            $table->integer('JCId');
            $table->tinyInteger('PersonalData')->default(0);
            $table->tinyInteger('AddressData')->default(0);
            $table->tinyInteger('FamilyData')->default(0);
            $table->tinyInteger('EducationalData')->default(0);
            $table->tinyInteger('LanguageData')->default(0);
            $table->tinyInteger('PreOrgData')->default(0);
            $table->tinyInteger('VnrData')->default(0);
            $table->tinyInteger('PFData')->default(0);
            $table->tinyInteger('WorkExpData')->default(0);
            $table->tinyInteger('TrainingData')->default(0);
            $table->tinyInteger('ctcData')->default(0);
            $table->tinyInteger('elgData')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processdatatoess');
    }
}
