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
    public $limit_exceeded=false;
    public $entry;
    public $survey;
    public $questions = [];
    public $user;
    public $multiple = [];
    public $single = [];
    public $text = [];

    public function mount(ModelSurvey $survey, $user_id)
    {
        $this->survey = $survey;
        if($survey->questions->count()===0)return;
        $model_user_name = app(config('lw-survey.models.user'));
        $this->user = $model_user_name->find($user_id);
        if(!$survey->limitExceeded($this->user->id)){
            $entry = Entry::where('user_id',$user_id)->where('survey_id',$survey->id)->where('completed_at',null)->first();
            if($entry==null){
                $this->entry = Entry::create(['survey_id' => $this->survey->id, 'user_id' => $user_id]);
            }else{
                $this->entry = $entry;
            }
            $this->questions = $survey->questionsNotAnswered($this->entry)->get();
        }else{
            $this->limit_exceeded=true;
        }
    }

    public function render()
    {
        if($this->limit_exceeded){
            return <<<'blade'
            <div style="margin-top: 1em;border:1px solid;border-color:#d2d6dd;border-radius:0.25rem;">
                <div style="font-size: 3rem;text-align: center;font-weight: 500;">{{$survey->name}}</div>
                <div style="text-align: center;">Ya has agotado los intentos para responder esta encuesta</div>
            </div>
            blade;
        }else{
            return view('lw-survey::livewire.survey');
        }
    }

    public function answer()
    {
        foreach($this->questions as $question){
            $content = null;
            $points = null;
            $option_id = null;
            switch ($question->question_type->id) {
                case QuestionType::$single:
                    $option = isset($this->single[$question->id])?$this->single[$question->id]:null;
                    if(!is_null($option)){
                        $option = Option::find($option);
                        $points = $option->value;
                        $option_id = $option->id;
                    }
                    break;
                case QuestionType::$multiple:
                    
                    break;
                case QuestionType::$text:
                    $content = isset($this->text[$question->id])?$this->text[$question->id]:null;
                    break;
            }
            if($question->question_type_id == QuestionType::$multiple && isset($this->multiple[$question->id])){
                foreach ($this->multiple[$question->id] as $key => $option) {
                    if($option){
                        $option = Option::find($key);
                        $points = $option->value;
                        $option_id = $option->id;
                        Answer::create([
                            'entry_id'=>$this->entry->id,
                            'user_id'=>$this->user->id,
                            'survey_id'=>$this->survey->id,
                            'question_id'=>$question->id,
                            'option_id'=>$option_id,
                            'points'=>$points,
                            'content' =>$content
                        ]);
                    }
                }
            }elseif((!is_null($option) && $question->question_type_id == QuestionType::$single) 
                || ($question->question_type_id==QuestionType::$text && isset($this->text[$question->id]))){
                $answer = Answer::create([
                    'entry_id'=>$this->entry->id,
                    'user_id'=>$this->user->id,
                    'survey_id'=>$this->survey->id,
                    'question_id'=>$question->id,
                    'option_id'=>$option_id,
                    'points'=>$points,
                    'content' =>$content
                ]);
            }
        }
        $this->multiple = [];
        $this->single = [];
        $this->text = [];
        $this->questions = $this->survey->questionsNotAnswered($this->entry)->inRandomOrder()->get();
        if($this->questions->count()==0 && $this->survey->questions->count()>0){
            $this->entry->completed_at = Carbon::now();
            $this->entry->update();
        }
    }
}
