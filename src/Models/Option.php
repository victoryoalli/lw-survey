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
}
