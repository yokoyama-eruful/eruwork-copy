@extends('chat::general.layouts.chat-widget')

@section('content')
  <div
    class="mt-[13px] hidden h-[calc(100vh-100px)] min-w-[1300px] flex-col rounded-[10px] bg-white p-5 shadow-[0_4px_13px_rgba(93,95,98,0.25)] sm:flex">
    <!-- 上のエリア -->
    <div class="h-[40px]">
      <div class="grid grid-cols-[50px,auto,200px]" x-data="{ showMemberList: false }">
        @if ($selectGroup->IconImage)
          <img class="h-10 w-10 rounded-full border bg-white" src="{{ $selectGroup->IconImage }}" alt="アイコン">
        @else
          <div class="flex h-10 w-10 items-center justify-center rounded-full border bg-white">
            <i class="fa-solid fa-image"></i>
          </div>
        @endif
        <div class="flex items-center truncate text-xl font-bold">{{ $selectGroup->NameLabel }}</div>
        @if (!$selectGroup->is_dm)
          <div class="flex items-center justify-end space-x-[10px]" @click="$dispatch('open-modal', 'view-member')">
            <div class="text-sm">{{ Auth::user()->name }}</div>
            <div class="text-xs text-[#AAB0B6]">他{{ $selectGroup->CountUser }}名</div>
            <div class="flex -space-x-3">
              @foreach ($selectGroup->users->take(4) as $user)
                @if ($user->IconImage)
                  <img class="h-8 w-8 rounded-full border bg-white" src="{{ $user->IconImage }}" alt="アイコン">
                @else
                  <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white">
                    <i class="fa-solid fa-image"></i>
                  </div>
                @endif
              @endforeach
            </div>
          </div>
          <x-modal-alert name="view-member">
            <div class="text-center text-lg font-bold">グループメンバー</div>
            <div class="my-2 h-auto max-h-96 overflow-y-auto rounded-md border p-2 shadow">
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
      <hr class="-mx-5 mt-[10px] border-t" />
    </div>

    <!-- スクロールさせたい中身 -->
    <div class="mt-3 flex-1 overflow-y-auto">
      @livewire('chat::general.talk-area', ['group' => $selectGroup])
    </div>

    <!-- 下のエリア -->
    <div class="min-h-[100px]">
      @vite(['Modules/Chat/resources/js/tiptap.js', 'resources/css/tiptap.css'])
      @livewire('chat::general.editor', ['group' => $selectGroup])
    </div>
  </div>

  {{-- モバイル版 --}}
  <div
    class="absolute inset-0 top-[50px] h-[calc(100vh-50px)] transform bg-white transition-transform duration-300 sm:hidden"
    x-show="mobileMemberArea == false" x-transition:enter="translate-x-full" x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="translate-x-full" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full">
    <div class="flex h-[50px] items-center justify-between border-b px-[14px]">
      <div class="flex items-center" x-on:click="mobileMemberArea=true">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M6.43337 10.4417C6.31633 10.3245 6.25058 10.1657 6.25058 10C6.25058 9.83441 6.31633 9.67556 6.43337 9.55837L12.6834 3.30837C12.8018 3.19797 12.9586 3.13787 13.1205 3.14072C13.2824 3.14358 13.4369 3.20917 13.5514 3.32368C13.6659 3.43819 13.7315 3.59268 13.7343 3.7546C13.7372 3.91652 13.6771 4.07322 13.5667 4.1917L7.75837 10L13.5667 15.8084C13.6281 15.8656 13.6774 15.9346 13.7115 16.0113C13.7457 16.0879 13.764 16.1707 13.7655 16.2546C13.767 16.3385 13.7516 16.4219 13.7201 16.4997C13.6887 16.5775 13.6419 16.6482 13.5826 16.7076C13.5232 16.7669 13.4525 16.8137 13.3747 16.8451C13.2969 16.8766 13.2135 16.892 13.1296 16.8905C13.0457 16.889 12.9629 16.8707 12.8863 16.8365C12.8096 16.8024 12.7406 16.7531 12.6834 16.6917L6.43337 10.4417Z"
            fill="#3289FA" />
        </svg>
        @if ($selectGroup->IconImage)
          <img class="h-[30px] w-[30px] rounded-full border bg-white" src="{{ $selectGroup->IconImage }}" alt="アイコン">
        @else
          <div class="flex h-[30px] w-[30px] items-center justify-center rounded-full border bg-white">
            <i class="fa-solid fa-image"></i>
          </div>
        @endif
        <div class="flex items-center truncate pl-2 text-[15px] font-bold">{{ $selectGroup->NameLabel }}</div>
      </div>
      @if (!$selectGroup->is_dm)
        <div class="flex items-center justify-end space-x-[10px]" @click="$dispatch('open-modal', 'view-member')">
          <div class="flex -space-x-3">
            @foreach ($selectGroup->users->take(4) as $user)
              @if ($user->IconImage)
                <img class="h-8 w-8 rounded-full border bg-white" src="{{ $user->IconImage }}" alt="アイコン">
              @else
                <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white">
                  <i class="fa-solid fa-image"></i>
                </div>
              @endif
            @endforeach
          </div>
          <div class="text-xs text-[#AAB0B6]">他{{ $selectGroup->CountUser }}名</div>
        </div>
        <x-modal-alert name="view-member">
          <div class="text-center text-lg font-bold">グループメンバー</div>
          <div class="my-2 h-auto max-h-96 overflow-y-auto rounded-md border p-2 shadow">
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
    <div class="mt-3 h-[calc(100vh-210px)] overflow-y-auto">
      @livewire('chat::general.talk-area', ['group' => $selectGroup])
    </div>

    <!-- 下のエリア -->
    <div class="min-h-[100px]">
      @vite(['Modules/Chat/resources/js/tiptap.js', 'resources/css/tiptap.css'])
      @livewire('chat::general.editor', ['group' => $selectGroup])
    </div>
  </div>
@endsection
