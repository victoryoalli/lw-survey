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
    public function survey()
    {
        return $this->belongsTo(config('lw-survey.models.survey'), config('lw-survey.models.survey_id'));
    }
    public function answers(){
        return $this->hasMany(Answer::class);
    }
    public function getApprovedAttribute(){
        return $this->percentage >= $this->survey->approved_grade;
    }
}
