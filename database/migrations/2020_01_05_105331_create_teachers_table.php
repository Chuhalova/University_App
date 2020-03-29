<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('workbooknumber');
            $table->integer('baseinfo_id_for_teacher')->unsigned();
            $table->foreign('baseinfo_id_for_teacher')->references('id')->on('baseinfos');
            $table->string('science_degree');
            $table->string('scientific_rank');
            $table->string('position');
            $table->date('start_date');
            $table->date('end_of_work_date')->nullable();
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
        Schema::dropIfExists('teachers');
    }
}
