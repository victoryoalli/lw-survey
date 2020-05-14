<?php

namespace VictorYoalli\LwSurvey\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('lw-survey.database.tables.surveys'));
    }

    protected $fillable = ['name', 'setting'];

    protected $casts = ['settings' => 'array'];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
