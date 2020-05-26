<?php

namespace VictorYoalli\LwSurvey\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyType extends Model
{
    use \Sushi\Sushi;

    public static $exam = 1;
    public static $survey = 2;

    protected $schema = ['id' => 'integer'];

    public function getRows()
    {
        return [
            ['id' => static::$exam, 'name' => 'Exam', ],
            ['id' => static::$survey, 'name' => 'Survey', ],
        ];
    }
}
