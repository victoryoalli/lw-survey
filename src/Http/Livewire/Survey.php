<?php

namespace VictorYoalli\LwSurvey\Http\Livewire;

use Livewire\Component;
use VictorYoalli\LwSurvey\Models\Answer;
use VictorYoalli\LwSurvey\Models\Entry;
use VictorYoalli\LwSurvey\Models\Option;
use VictorYoalli\LwSurvey\Models\Survey as ModelSurvey;
use Carbon\Carbon;
use VictorYoalli\LwSurvey\Models\QuestionType;

class Survey extends Component
{
    public $entry;
    public $survey;
    public $question;
    public $user;
    public $selected = [];
    public $text;

    public function mount(ModelSurvey $survey, $user_id)
    {
        $this->survey = $survey;
        if($survey->questions->count()===0)return;
        $model_user_name = app(config('lw-survey.models.user'));
        $this->user = $model_user_name->find($user_id);
        $entry = Entry::where('user_id',$user_id)->where('survey_id',$survey->id)->where('completed_at',null)->first();
        if($entry==null){
            $this->entry = Entry::create(['survey_id' => $this->survey->id, 'user_id' => $user_id]);
        }else{
            $this->entry = $entry;
        }
        $this->question = $survey->questionsNotAnswered($this->entry)->inRandomOrder()->first();
    }

    public function render()
    {
        return view('lw-survey::livewire.survey');
    }

    public function answer($option)
    {
        $content = null;
        $points = null;
        $option_id = null;
        $option = Option::find($option);
        switch ($this->question->question_type->id) {
            case QuestionType::$single:
                $points = $option->value;
                $option_id = $option->id;
                break;
            case QuestionType::$multiple:
                $content = collect($this->selected)->toJson();
                break;
            case QuestionType::$text:
                $content = $this->text;
                break;
        }

        
        if(count($this->selected)>0){
            foreach ($this->selected as $option) {
                $option = Option::find($option);
                $points = $option->value;
                $option_id = $option->id;
                Answer::create([
                    'entry_id'=>$this->entry->id,
                    'user_id'=>$this->user->id,
                    'survey_id'=>$this->user->id,
                    'question_id'=>$this->question->id,
                    'option_id'=>$option_id,
                    'points'=>$points,
                    'content' =>$content
                ]);
            }
        }else{
            $answer = Answer::create([
                'entry_id'=>$this->entry->id,
                'user_id'=>$this->user->id,
                'survey_id'=>$this->user->id,
                'question_id'=>$this->question->id,
                'option_id'=>$option_id,
                'points'=>$points,
                'content' =>$content
            ]);
        }
        $this->selected = [];
        $this->text = null;
        $this->question = $this->survey->questionsNotAnswered($this->entry)->inRandomOrder()->first();
        if($this->question==null && $this->survey->questions->count()>0){
            $this->question = null;
            $this->entry->completed_at = Carbon::now();
            $this->entry->update();
        }
    }
}
