<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use VictorYoalli\LwSurvey\Models\QuestionType;

class CreateLwQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('lw-survey.database.tables.questions'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id');
            $table->foreignId('section_id')->nullable();
            $table->text('content');
            $table->unsignedInteger('position')->default(0);
            $table->unsignedInteger('question_type_id')->default(QuestionType::$single); //text,radio,checkbox,select
            $table->json('rules')->nullable();//number:min,max, email
            $table->unsignedInteger('points')->default(0);
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
        Schema::dropIfExists(config('lw-survey.database.tables.questions'));
    }
}
