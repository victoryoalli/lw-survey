<?php

namespace VictorYoalli\LwSurvey\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('lw-survey.database.tables.entries'));
    }

    protected $fillable = ['user_id', 'survey_id', 'completed_at'];

    public function user()
    {
        return $this->belongsTo(config('lw-survey.models.user'), config('lw-survey.models.user_id'));
    }
    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
