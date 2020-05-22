<div style="margin:1rem; padding:1rem; border:1px solid;border-color:#d2d6dd;border-radius:0.25rem;">
    <h1 style="margin:1rem auto .5rem; font-size:2.5em;">{{$survey->name}}</h1>
    <pre>{{json_encode($multiple)}}</pre>
    @if($section)
        <h2 style="margin:1rem auto .5rem; font-size:2em;">{{$section->name}}</h2>
    @endif
    @if($survey->questions->count()===0)
        <p>No hay preguntas</p>
    @elseif($questions->count()==0)
        <p>Finished</p>
    @elseif($survey->questions->count()>0)
        @foreach($questions as $question)
        <div style="margin-top:2rem;">
            <p style="font-size:1.25em;"> {{$question->content}} </p>
            @if($question->question_type->id == VictorYoalli\LwSurvey\Models\QuestionType::$single)
            <div style="display:flex; margin-left:.5em;margin-right:.5em;align-items: center;margin-top: 1em">
                @foreach($question->options as $option)

{{-- <label style="margin-right: 1rem; padding: .5rem;"> <input id="{{'question_single'.$question->id.$option->id}}" name="{{'question_single'.$question->id}}" value="{{$option->id}}" wire:model="single.{{$question->id}}" type="radio" /> </label> --}}
                    <div style="@if($single[$question->id]==$option->id) border:3px solid blue; @endif margin:.25rem; padding:1rem; background-color:gray;" wire:click="select({{$question->id}},{{$option->id}})">
                        <span style="margin: auto 1rem;">{{$option->content}}</span>
                    </div>
                @endforeach
            </div>
            @elseif($question->question_type->id == VictorYoalli\LwSurvey\Models\QuestionType::$multiple)
            <div style="display:flex;margin-left:.5em;margin-right:.5em;align-items: center;margin-top: 1em">
                @foreach($question->options as $option)
                {{--
                <label style="margin-right: 1rem; padding: .5rem;">
                    <input name="question_multiple[]" id="" wire:model="multiple.{{ $question->id }}.{{$option->id}}" id="{{'question_check'.$question->id.$option->id}}" name="{{'question_check'.$question->id.$option->id}}" type="checkbox" />
                    <span style="margin:auto 1rem;"> {{$option->content}} </span>
                </label>
                --}}
                <div style="@if(isset($multiple[$question->id]) &&isset($multiple[$question->id][$option->id]) &&$multiple[$question->id][$option->id]==true ) border:3px solid blue; @endif margin:1rem;padding:1rem;background-color:#ccc;" wire:click="multipleSelect({{$question->id}},{{$option->id}})">
                    <span style="margin:auto 1rem;"> {{$option->content}} </span>
                </div>
                @endforeach
            </div>
            @elseif($question->question_type->id == VictorYoalli\LwSurvey\Models\QuestionType::$text)
            <div style="margin-top: 1em">
                <input style="width:100%; margin:0 auto 1rem ; line-height: 1.8rem;padding:.5rem;font-size:1.2em; border-radius: 5px; border:1px solid #999;" type="text" wire:model="text.{{$question->id}}" id="{{'question_'.$question->id}}"/>
            </div>
            @endif
        </div>
        @endforeach
        <div style="display:flex;justify-content: flex-end;">
            <button style="background-color:#369; color:#fff; padding:.5rem; margin:1rem; border-radius: 5px;" wire:click="save()">
                <svg style="height: 1.5rem; width:1.5rem" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
            </button>
        </div>
    @endif
</div>