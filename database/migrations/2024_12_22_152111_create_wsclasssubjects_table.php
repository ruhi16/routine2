<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWsclasssubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wsclasssubjects', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('wsclass_id');
            // $table->foreign('wsclass_id')->references('id')->on('wsclasses')->onDelete('cascade');

            $table->unsignedBigInteger('wssubject_id');
            // $table->foreign('wssubject_id')->references('id')->on('wssubjects')->onDelete('cascade');

            
            


            

            
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
        Schema::dropIfExists('wsclasssubjects');
    }
}