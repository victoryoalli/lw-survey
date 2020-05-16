<div>
    {{-- Success is as dangerous as failure. --}}
    <h1>Hello World</h1>
    <h1 class="mt-6" style="text-size:3rem;">{{$survey->name}}</h1>
    @if($survey->questions->count()===0)
    <p>No hay preguntas</p>
    @elseif($survey->questions->count()>0)
    <h3>
        {{$question->content}}
    </h3>
    
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

    @elseif($question==null)
        <p>Finished</p>
    @endif
</div>