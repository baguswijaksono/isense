<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cd_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deviceid');
            $table->integer('peoplecount');
            $table->integer('people_with_mask');
            $table->integer('people_without_mask');
            $table->date('date');
            $table->time('time');
            $table->integer('hours')->nullable();
            $table->integer('minutes')->nullable();
            $table->integer('seconds')->nullable();
        });
    }
    

    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cd_statistic');
    }
};
