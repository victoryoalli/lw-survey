<?php

namespace VictorYoalli\LwSurvey\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $appends = ['limit_entries_participant'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('lw-survey.database.tables.surveys'));
    }

    protected $fillable = ['name', 'setting'];

    protected $casts = ['settings' => 'collection'];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function hasSections()
    {
        return $this->sections()->exists();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function withoutSection()
    {
        return $this->questions()->withoutSection();
    }

    public function limitExceeded($user_id)
    {
        if ($this->limit_entries_per_participant == 0) {
            return false;
        }
        $entry = Entry::where('user_id', $user_id)->where('survey_id', $this->id)->whereNotNull('completed_at')->get();
        if ($entry->count() >= $this->limit_entries_per_participant) {
            return true;
        }
        return false;
    }

    public function questionsNotAnswered(Entry $entry = null)
    {
        return $this->questions()->notAnswered($entry);
    }

    public function getLimitEntriesPerParticipantAttribute()
    {
        return $this->settings == null ? 0 : $this->settings->get('limit_entries_per_participant') ?? 0;
    }

    public function setLimitEntriesPerParticipantAttribute($value)
    {
        $this->settings = collect($this->settings)->put('limit_entries_per_participant', $value);
    }

    public function getGroupQuestionsPerSectionAttribute():bool
    {
        return $this->settings == null ? false : $this->settings->get('group_questions_per_section') ?? false;
    }

    public function setGroupQuestionsPerSectionAttribute($value)
    {
        $this->settings = collect($this->settings)->put('group_questions_per_section', $value);
    }

    public function getQuestionsPerPageAttribute()
    {
        return $this->settings == null ? 0 : $this->settings->get('questions_per_page') ?? 1;
    }

    public function setQuestionsPerPageAttribute($value)
    {
        $this->settings = collect($this->settings)->put('questions_per_page', $value);
    }
}
