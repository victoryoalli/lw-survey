<div style="margin-top: 1em;border:1px solid;border-color:#d2d6dd;border-radius:0.25rem;">
    <div style="font-size: 3rem;text-align: center;font-weight: 500;">{{$survey->name}}</div>
    @if($survey->questions->count()===0)
        <p>No hay preguntas</p>
    @elseif($questions->count()==0)
        <p>Finished</p>
    @elseif($survey->questions->count()>0)
        @foreach($questions as $question)
        <div style="text-align: center;">
            <div>
                {{$question->content}}
            </div>

            @if($question->question_type->id == VictorYoalli\LwSurvey\Models\QuestionType::$single)
            <div class="" style="margin-left:.5em;margin-right:.5em;align-items: center;margin-top: 1em">
                @foreach($question->options as $option)
                <label>{{$option->content}}</label>
                <input style="margin-left:.5em;margin-right:.5em;" type="radio" name="{{'question_'.$question->id}}" value="{{$option->id}}" wire:model="single.{{$question->id}}" />
                <!-- <button class="p-2 mx-2 text-white bg-primary-500" wire:click="answer({{$option->id}})">{{$option->content}}</button> -->
                @endforeach
            </div>
            @elseif($question->question_type->id == VictorYoalli\LwSurvey\Models\QuestionType::$multiple)
            <div class="text-primary-500" style="align-items: center;margin-top: 1em">
                @foreach($question->options as $option)
                <label>{{$option->content}}</label>
                <input name="options[]" id="" wire:model="multiple.{{ $question->id }}.{{$option->id}}" type="checkbox" />
                @endforeach
            </div>
            <!-- <button class="p-2 mx-2 text-white bg-primary-500" wire:click="answer()">Guardar</button> -->
            @elseif($question->question_type->id == VictorYoalli\LwSurvey\Models\QuestionType::$text)
            <div class="text-primary-500 my-2" style="margin-top: 1em">
                <label class="w-full">Escribe tu respuesta</label></br>
                <input type="text" class="border" wire:model="text.{{$question->id}}" />
            </div>
            <!-- <button class="p-2 mx-2 text-white bg-primary-500" wire:click="answer()">Guardar</button> -->
            @endif
        </div>
        @endforeach
        <button class="p-2 mx-2 text-white bg-primary-500" wire:click="answer()">Guardar</button>
    @endif
</div>