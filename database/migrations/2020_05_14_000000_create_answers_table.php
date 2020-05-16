<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('lw-survey.database.tables.answers'), function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('entry_id');
            $table->foreignId('user_id');
            $table->foreignId('survey_id');
            $table->foreignId('question_id');
            $table->foreignId('option_id')->nullable();
            $table->text('content')->nullable();
            $table->unsignedInteger('points')->nullable();
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
        Schema::dropIfExists(config('lw-survey.database.tables.answers'));
    }
}
