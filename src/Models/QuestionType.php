<?php

namespace VictorYoalli\LwSurvey\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('lw-survey.database.tables.question_types','lw_question_types'));
    }

    const SINGLE = 'single';
    const  MULTIPLE = 'multiple';
    const TEXT = 'text';

    protected $casts = ['rules' => 'array'];
}
