<?php

namespace VictorYoalli\LwSurvey\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('lw-survey.database.tables.questions'));
    }

    protected $fillable = ['survey_id', 'section_id', 'content', 'type', 'rules'];

    protected $casts = ['rules' => 'array'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function scopeWithoutSection($query)
    {
        return $query->where('section_id', null);
    }
}
