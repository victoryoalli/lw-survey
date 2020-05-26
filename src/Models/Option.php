<?php

namespace VictorYoalli\LwSurvey\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('lw-survey.database.tables.options'));
    }

    protected $fillable = ['question_id', 'content', 'value', 'position'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    protected static function boot()
    {
        parent::boot();

        //Ensure the question's survey is the same as the section it belongs to.
        static::saved(function (self $option) {
            $option->load('question');
            $question = $option->question;
            $question->load('options');
            $options = $question->options;
            $points = 0;
            if($question->question_type_id == QuestionType::$single){
                $question->points = $options->max('value');
                $question->save();
            }
            elseif($question->question_type_id == QuestionType::$multiple){
                $question->points = $options->sum('value');
                $question->save();
            }
        });
    }
}
