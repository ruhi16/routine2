<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWssubjectteachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wssubjectteachers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('wssubject_id');
            // $table->foreign('wssubject_id')->references('id')->on('wssubjects')->onDelete('cascade');

            $table->unsignedBigInteger('wsteacher_id');
            // $table->foreign('wsteacher_id')->references('id')->on('wsteachers')->onDelete('cascade');



            
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
        Schema::dropIfExists('wssubjectteachers');
    }
}
