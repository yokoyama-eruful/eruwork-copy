@extends('chat::layouts.chat-widget')

@section('content')
  <div class="relative flex h-full flex-col">
    <div class="h-12 bg-ao-sub p-2">
      <div class="flex flex-row items-center space-x-2">
        {{-- mobileメニュー --}}
        <div x-data="{ showMemberList: false }">
          <i class="fa-solid fa-chevron-left block hover:text-ao-main xl:hidden" x-on:click="showMemberList=true"></i>
          <div class="absolute inset-0 z-30 transform bg-white transition-transform duration-300 ease-in-out"
            x-show="showMemberList===true" x-transition:enter="-translate-x-full opacity-0"
            x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-cloak>
            @livewire('chat::member-list', ['selectGroup' => $selectGroup])
          </div>
        </div>
        {{-- モバイルメニュー --}}
        @if ($selectGroup->IconImage)
          <img class="h-8 w-8 rounded-full border bg-white" src="{{ $selectGroup->IconImage }}" alt="アイコン">
        @else
          <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white">
            <i class="fa-solid fa-image"></i>
          </div>
        @endif
        <div class='flex flex-row space-x-1'>
          <div>{{ $selectGroup->NameLabel }}</div>
          @if (!$selectGroup->is_dm)
            <div class='cursor-pointer hover:text-ao-main' @click="$dispatch('open-modal', 'view-member')">
              {{ '(' . $selectGroup->CountUser . ')' }}</div>
            <x-modal-alert name="view-member">
              <div class="text-center text-lg font-bold">グループメンバー</div>
              <div class="my-2 max-h-32 min-h-32 overflow-y-auto rounded-md border p-2 shadow">
                @foreach ($selectGroup->users as $user)
                  <div class="flex w-full flex-row items-center border-b p-2">
                    @if ($user->IconImage)
                      <img class="h-8 w-8 rounded-full border bg-white" src="{{ $group->IconImage }}" alt="アイコン">
                    @else
                      <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white"><i
                          class="fa-solid fa-image"></i>
                      </div>
                    @endif
                    <div>{{ $user->name }}</div>
                  </div>
                @endforeach
              </div>
            </x-modal-alert>
          @endif
        </div>
      </div>
    </div>

    <div class="flex h-full flex-col">
      @livewire('chat::talk-area', ['group' => $selectGroup])
      <div class="flex h-auto items-center border-t bg-white p-3">
        @vite(['Modules/Chat/resources/js/tiptap.js', 'resources/css/tiptap.css'])
        @livewire('chat::editor', ['group' => $selectGroup])
      </div>
    </div>

  </div>
@endsection
