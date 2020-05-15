<?php

namespace VictorYoalli\LwSurvey\Http\Livewire;

use Livewire\Component;
use VictorYoalli\LwSurvey\Models\Entry;
use VictorYoalli\LwSurvey\Models\Survey as ModelSurvey;

class Survey extends Component
{
    public $entry;
    public $survey;
    public $question;
    public $user_id;

    public function mount(ModelSurvey $survey, $user_id)
    {
        $this->survey = $survey;
        $this->question = $survey->questions()->with('options')->inRandomOrder()->first();
        $this->entry = Entry::create(['survey_id' => $this->survey->id, 'user_id' => $user_id]);
    }

    public function render()
    {
        return view('lw-survey::livewire.survey');
    }

    public function answer($option)
    {
        //$entry->answers()
        $survey->questionsNotAnswered($this->entry)->get();
        // $this->question = $this->survey-
    }
}
