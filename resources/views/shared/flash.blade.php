@if($message = flash()->get())
    <div class="{{$message->class()}} p-5">
        {{$message->message()}}
    </div>
    {{session('message')}}
@endif
