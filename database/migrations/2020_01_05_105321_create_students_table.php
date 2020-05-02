<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('baseinfo_id_for_student')->unsigned();
            $table->foreign('baseinfo_id_for_student')->references('id')->on('baseinfos');
            $table->string('studnumber');
            $table->date('entry_date');
            $table->integer('year')->unsigned();
            $table->date('real_grad_date')->nullable();
            $table->enum('degree',['bachelor', 'master'])->default('master');
            $table->string('specialty');
            $table->string('specialty_abbr');
            $table->integer('group')->unsigned()->default(1);
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
        Schema::dropIfExists('students');
    }
}
