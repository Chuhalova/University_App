<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScienceworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scienceworks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('topic');
            $table->enum('type',['bachaelor coursework','bachaelor dyploma', 'major coursework','major dyploma'])->default('bachaelor coursework');
            $table->date('presenting_date')->nullable();
            $table->enum('status',['created_by_teacher','disapproved_for_teacher','disapproved_for_student','inactive', 'approved_by_teacher', 'active'])->default('inactive');
            $table->integer('student_id')->unsigned()->nullable();
            $table->foreign('student_id')->references('id')->on('students');
            $table->integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->integer('cathedra_id')->unsigned();
            $table->foreign('cathedra_id')->references('id')->on('cathedras');
            $table->boolean('application')->default(false);
            $table->string('comment')->nullable();
            $table->string('uploaded_work_file')->nullable();
            $table->text('uploaded_work_comment')->nullable();
            $table->enum('workfile_check_status',['unchecked','checked','approved_file'])->default('unchecked');
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
        Schema::dropIfExists('scienceworks');
    }
}
