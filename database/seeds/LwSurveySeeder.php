<?php

use VictorYoalli\LwSurvey\Models\QuestionType;
use VictorYoalli\LwSurvey\Models\SurveyType;
use Illuminate\Database\Seeder;

class LwSurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionType::firstOrCreate([
            'name' => 'Single',
            'keyname' => 'single'
        ]);
        QuestionType::firstOrCreate([
            'name' => 'Multiple',
            'keyname' => 'multiple'
        ]);
        QuestionType::firstOrCreate([
            'name' => 'Text',
            'keyname' => 'text'
        ]);
        SurveyType::firstOrCreate([
            'name' => 'Exam',
            'keyname' => 'exam'
        ]);
        SurveyType::firstOrCreate([
            'name' => 'Survey',
            'keyname' => 'survey'
        ]);
    }
}