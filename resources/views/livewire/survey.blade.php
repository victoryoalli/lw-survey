<div style="margin-top: 1em;border:1px solid;border-color:#d2d6dd;border-radius:0.25rem;">
    <div style="font-size: 3rem;text-align: center;font-weight: 500;">{{$survey->name}}</div>
    @if($survey->questions->count()===0)
    <p>No hay preguntas</p>
    @elseif($question==null)
        <p>Finished</p>
    @elseif($survey->questions->count()>0)
    
    <div>
        {{$question->content}}
    </div>
    @if($question->question_type->id == VictorYoalli\LwSurvey\Models\QuestionType::$single)
        <div class="flex">
            @foreach($question->options as $option)
                <button class="p-2 mx-2 text-white bg-primary-500" wire:click="answer({{$option->id}})">{{$option->content}}</button>
            @endforeach
        </div>
    @elseif($question->question_type->id == VictorYoalli\LwSurvey\Models\QuestionType::$multiple)
        <div class="text-primary-500">
            @foreach($question->options as $option)
                <label>{{$option->content}}</label>
                <input name="options[]" wire:model="selected"  type="checkbox" value="{{$option->id}}"/>
            @endforeach
        </div>
        <button class="p-2 mx-2 text-white bg-primary-500" wire:click="answer()">Guardar</button>
    @elseif($question->question_type->id == VictorYoalli\LwSurvey\Models\QuestionType::$text)
        <div class="text-primary-500 my-2">
            <label class="w-full">Escribe tu respuesta</label></br>
            <input type="text" class="border" wire:model="text"/>
        </div>
        <button class="p-2 mx-2 text-white bg-primary-500" wire:click="answer()">Guardar</button>
    @endif
    @endif
</div>