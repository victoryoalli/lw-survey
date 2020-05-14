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
}
