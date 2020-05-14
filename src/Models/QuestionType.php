<?php

namespace VictorYoalli\LwSurvey\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use \Sushi\Sushi;

    public static $single = 1;
    public static $multiple = 2;
    public static $text = 3;

    protected $schema = ['id' => 'integer'];
    protected $casts = ['rules' => 'array'];

    public function getRows()
    {
        return [
            ['id' => static::$single, 'name' => 'single', ],
            ['id' => static::$multiple, 'name' => 'multiple', ],
            ['id' => static::$text, 'name' => 'text', ],
        ];
    }
}
