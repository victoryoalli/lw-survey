<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use VictorYoalli\LwSurvey\Models\QuestionType;

class CreateLwQuestionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('lw-survey.database.tables.question_types'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('keyname');
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
        Schema::dropIfExists(config('lw-survey.database.tables.question_types'));
    }
}
