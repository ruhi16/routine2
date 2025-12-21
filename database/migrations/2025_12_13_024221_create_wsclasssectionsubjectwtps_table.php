<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWsclasssectionsubjectwtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wsclasssectionsubjectwtps', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('wsclass_id');
            $table->unsignedBigInteger('wssection_id');
            $table->unsignedBigInteger('wssubject_id');
            $table->unsignedBigInteger('weekly_total_periods')->nullable();
            
            $table->unsignedBigInteger('school_id');            
            $table->unsignedBigInteger('session_id');
            
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
        Schema::dropIfExists('wsclasssectionsubjectwtps');
    }
}
