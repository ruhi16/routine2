<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWssubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wssubjects', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->string('name_in_short')->nullable();
            $table->integer('name_sequence')->nullable();
            $table->integer('priority_star_out_of_5')->nullable();


            $table->enum('subject_type', ['Formative', 'Summative'])->nullable();
            $table->enum('subject_category', ['Upper Primary', 'Secondary', 'Higher Secondary'])->nullable();


            


            
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
        Schema::dropIfExists('wssubjects');
    }
}
