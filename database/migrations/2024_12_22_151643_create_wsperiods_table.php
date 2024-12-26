<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWsperiodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wsperiods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('name_sequence')->nullable();
            
            








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
        Schema::dropIfExists('wsperiods');
    }
}
