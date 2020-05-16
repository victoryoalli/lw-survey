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

    public function question_type()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    
    public function scopeNotAnswered($query,Entry $entry=null){
        $answers = Answer::where('entry_id',$entry->id)->get()->pluck('question_id');
        return $query->whereNotIn('id',$answers);
    }

    public function scopeWithoutSection($query)
    {
        return $query->where('section_id', null);
    }
    

    protected static function boot()
    {
        parent::boot();

        //Ensure the question's survey is the same as the section it belongs to.
        static::creating(function (self $question) {
            $question->load('section');

            if ($question->section) {
                $question->survey_id = $question->section->survey_id;
            }
        });
    }
}
