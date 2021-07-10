<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateEntitlementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_entitlement', function (Blueprint $table) {
            $table->integer('ENTId', true);
            $table->integer('JAId');
            $table->string('EntLetterNo', 60);
            $table->date('EntDate');
            $table->string('LoadCityA', 50);
            $table->string('LoadCityB', 50);
            $table->string('LoadCityC', 50);
            $table->string('DAOut', 50);
            $table->string('DAHq', 50);
            $table->string('TwoWheel', 50);
            $table->string('FourWheel', 50);
            $table->string('TravelMode', 50);
            $table->string('TravelClass', 50);
            $table->string('Mobile', 50);
            $table->string('MExpense', 50);
            $table->string('MTerm', 60);
            $table->tinyInteger('GPRS')->default(0);
            $table->string('Laptop', 50);
            $table->string('HealthIns', 50);
            $table->tinyInteger('TravelLine')->default(0);
            $table->dateTime('Created_on')->useCurrent();
            $table->integer('Created_by');
            $table->tinyInteger('Status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_entitlement');
    }
}
