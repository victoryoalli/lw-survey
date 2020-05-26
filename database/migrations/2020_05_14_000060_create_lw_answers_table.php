<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLwAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('lw-survey.database.tables.answers'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_id');
            $table->foreignId('user_id');
            $table->foreignId('survey_id');
            $table->foreignId('question_id');
            $table->foreignId('option_id')->nullable();
            $table->text('content')->nullable();
            $table->unsignedInteger('points')->nullable();
            $table->timestamps();
            $table->foreign('entry_id')->references('id')->on(config('lw-survey.database.tables.entries'))->onDelete('cascade');
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
        Schema::table(config('lw-survey.database.tables.answers'), function (Blueprint $table) {
            $table->dropForeign(['entry_id']);
        });
    }
}
