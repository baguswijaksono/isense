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
        Schema::create('ovcrowdalerts', function (Blueprint $table) {
            $table->id();
            $table->string('deviceid');
            $table->integer('peoplecount');
            $table->date('date');
            $table->time('time');
            $table->integer('hours')->nullable();
            $table->integer('minutes')->nullable();
            $table->integer('seconds')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ovcrowdalerts');
    }
};
