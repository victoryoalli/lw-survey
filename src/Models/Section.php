<?php

namespace VictorYoalli\LwSurvey\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('lw-survey.database.tables.sections'));
    }

    protected $fillable = ['name', 'survey_id'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
