<?php

namespace VictorYoalli\LwSurvey\Http\Livewire;

use Livewire\Component;
use VictorYoalli\LwSurvey\Models\Answer;
use VictorYoalli\LwSurvey\Models\Entry;
use VictorYoalli\LwSurvey\Models\Option;
use VictorYoalli\LwSurvey\Models\Survey as ModelSurvey;
use Carbon\Carbon;
use VictorYoalli\LwSurvey\Models\Question;
use VictorYoalli\LwSurvey\Models\QuestionType;

class Survey extends Component
{
    public $limit_exceeded = false;
    public $entry;
    public $survey;
    public $questions = [];
    public $user;
    public $multiple = [];
    public $single = null;
    public $text = '';
    public $section = null;
    public $points = null;
    public $max_points = null;
    public $percentage = null;

    public function mount(ModelSurvey $survey, $user_id)
    {
        $survey->load('questions');
        $this->survey = $survey;
        if ($survey->questions->count() === 0) {
            return;
        }
        $model_user_name = app(config('lw-survey.models.user'));
        $this->user = $model_user_name->find($user_id);
        $approved = $survey->approvedEntry($this->user->id);
        if(!is_null($approved)){
            $this->questions =  Question::where('id')->get();
            $this->points =     $approved->points;
            $this->max_points = $approved->max_points;
            $this->percentage = $approved->percentage;
        }
        elseif (!$survey->limitExceeded($this->user->id)) {
            $this->entry = Entry::firstOrCreate(['user_id' => $user_id, 'survey_id' => $survey->id, 'completed_at' => null]);
            $this->setup($survey);
        } else {
            $this->limit_exceeded = true;
        }
    }

    protected function setup($survey)
    {
        if ($survey->hasSections()) {
            $this->section = $this->currentSection($survey, $this->entry);
            if (!is_null($this->section)) {
                $query = $this->section->questions()->notAnswered($this->entry)->inRandomOrder();
                if ($survey->group_questions_per_section && $survey->questions_per_page > 0) {
                    $this->questions = $query->take($survey->questions_per_page)->get();
                } else {
                    $this->questions = $query->get();
                }
            } else {
                $this->questions = $survey->questions()->notAnswered($this->entry)->inRandomOrder()->withoutSection()->get();
            }
        } else {
            $this->section = null;
            $this->questions = $survey->questions()->notAnswered($this->entry)->inRandomOrder()->withoutSection()->get();
        }
    }

    public function select($question_id, $option_id)
    {
        $this->single[$question_id] = $option_id;
    }

    public function multipleValue($question_id, $option_id)
    {
        return true;
        $value = $this->multiple[$question_id][$option_id] ?? false;
        return $value;
    }

    public function multipleSelect($question_id, $option_id)
    {
        $value = $this->multiple[$question_id][$option_id] ?? false;
        $this->multiple[$question_id][$option_id] = !$value;
    }

    protected function currentSection($survey, $entry)
    {
        foreach ($survey->sections as $section) {
            $hasQuestions = $section->questions()->notAnswered($entry)->exists();
            if ($hasQuestions) {
                return $section;
            }
        }
        return null;
    }

    public function render()
    {
        if ($this->limit_exceeded) {
            return view('lw-survey::livewire.no_more_tries');
        } else {
            return view('lw-survey::livewire.survey');
        }
    }

    protected function saveAnswer($question, $option_id, $points, $content)
    {
        $answer = Answer::create([
            'entry_id' => $this->entry->id,
            'user_id' => $this->user->id,
            'survey_id' => $this->survey->id,
            'question_id' => $question->id,
            'option_id' => $option_id,
            'points' => $points,
            'content' => $content
        ]);
        return $answer;
    }

    public function save()
    {
        foreach ($this->questions as $question) {
            $content = null;
            $points = null;
            $option_id = null;
            $option = null;
            switch ($question->question_type->id) {
                case QuestionType::$single:
                    $option = isset($this->single[$question->id]) ? $this->single[$question->id] : null;
                    if (!is_null($option)) {
                        $option = Option::find($option);
                        $points = $option->value;
                        $option_id = $option->id;
                        $this->saveAnswer($question, $option_id, $points, $content);
                    }
                    break;
                case QuestionType::$multiple:
                    if (isset($this->multiple[$question->id])) {
                        foreach ($this->multiple[$question->id] as $key => $option) {
                            if ($option) {
                                $option = Option::find($key);
                                $points = $option->value;
                                $option_id = $option->id;
                                $this->saveAnswer($question, $option_id, $points, $content);
                            }
                        }
                    }
                    break;
                case QuestionType::$text:
                    if (isset($this->text[$question->id])) {
                        $content = $this->text[$question->id];
                        $this->saveAnswer($question, $option_id, $points, $content);
                    }
                    break;
            }
        }
        $this->multiple = [];
        $this->single = [];
        $this->text = [];
        $this->setup($this->survey->load(['questions', 'sections.questions']));
        if ($this->questions->count() == 0 && $this->survey->questions->count() > 0) {
            $this->points = $this->entry->answers->sum('points');
            $this->max_points = $this->survey->questions->sum('points');
            $this->percentage = $this->points/$this->max_points*100;
            $this->entry->completed_at = Carbon::now();
            $this->entry->points = $this->points;
            $this->entry->max_points = $this->max_points;
            $this->entry->percentage = $this->percentage;
            $this->entry->update();
        }
    }
}
