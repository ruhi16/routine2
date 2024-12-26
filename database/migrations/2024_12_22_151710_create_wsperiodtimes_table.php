<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWsperiodtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wsperiodtimes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('name_index')->nullable();

            $table->unsignedBigInteger('wsperiod_id');
            // $table->foreign('wsperiod_id')->references('id')->on('wsperiods')->onDelete('cascade');

            $table->unsignedBigInteger('wstime_id');
            // $table->foreign('wstime_id')->references('id')->on('wstimes')->onDelete('cascade');

            $table->integer('pt_group_id')->nullable();
            $table->integer('pt_group_sequence')->nullable();
            









            $table->unsignedBigInteger('school_id');
            // $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            
            $table->unsignedBigInteger('session_id');
            // $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            

            $table->boolean('is_active')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('wsperiodtimes');
    }
}
