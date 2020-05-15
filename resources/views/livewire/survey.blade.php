<div>
    {{-- Success is as dangerous as failure. --}}
    <h1>Hello World</h1>
    <h1 class="mt-6 text-4xl">{{$survey->name}}</h1>
    @if($question!=null)
    <h3>
        {{$question->content}}
    </h3>
    @endif
    <div class="flex">
        @foreach($question->options as $option)
        <button class="p-2 mx-2 text-white bg-primary-500" wire:click="answer({{$option->id}})">{{$option->content}}</button>
        @endforeach
    </div>
</div>