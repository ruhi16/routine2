<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWsdayperiodtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wsdayperiodtimes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('wsday_id');
            // $table->foreign('wsday_id')->references('id')->on('wsdays')->onDelete('cascade');

            $table->unsignedBigInteger('pt_group_id');
            // $table->foreign('pt_group_id')->references('id')->on('wsperiodtimes')->onDelete('cascade');








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
        Schema::dropIfExists('wsdayperiodtimes');
    }
}
