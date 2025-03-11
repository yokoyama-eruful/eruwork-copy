@extends('chat::layouts.chat-widget')

@section('content')
  <div class="bg-ao-sub p-2">
    <div class="flex flex-row items-center space-x-2">
      <img class="h-8 w-8 rounded-full border bg-white" src="{{ $selectGroup->IconImage }}" src="icon.png">
      <div>{{ $selectGroup->name }}</div>
    </div>
  </div>
@endsection
