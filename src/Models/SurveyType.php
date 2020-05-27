<?php

namespace VictorYoalli\LwSurvey\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyType extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('lw-survey.database.tables.survey_types','lw_survey_types'));
    }

    const EXAM = 'exam';
    const SURVEY = 'survey';
}
