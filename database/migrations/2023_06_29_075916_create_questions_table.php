<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question', 255);
            $table->string('subject_name')->nullable();
            $table->foreign('subject_name')->references('subject_name')->on('subjects'); 
            $table->integer('chapter_number')->unsigned();
            $table->integer('question_age')->unsigned()->increments();
            $table->integer('question_complexity')->unsigned();
            $table->integer('question_mark')->unsigned();
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
        Schema::dropIfExists('questions');
    }
}
