@extends('chat::layouts.chat-widget')

@section('content')
  <div class="flex h-full flex-col">
    <div class="h-12 bg-ao-sub p-2">
      <div class="flex flex-row items-center space-x-2">
        @if ($selectGroup->IconImage)
          <img class="h-8 w-8 rounded-full border bg-white" src="{{ $selectGroup->IconImage }}" alt="アイコン">
        @else
          <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white">
            <i class="fa-solid fa-image"></i>
          </div>
        @endif
        <div>{{ $selectGroup->name }}</div>
      </div>
    </div>

    <div class="flex h-full flex-col">
      @livewire('chat::talk-area', ['groupId' => $selectGroup->id])
      <div class="flex h-auto items-center border-t bg-white p-3">
        @vite(['Modules/Chat/resources/js/tiptap.js', 'resources/css/tiptap.css'])
        @livewire('chat::editor', ['groupId' => $selectGroup->id])
      </div>
    </div>

  </div>
@endsection
