<x-app-layout :url="route('chat.index')">
  <div class="flex w-full justify-between" x-data="{ viewGroupCreateDialog: false }" x-cloak>
    <div class="hidden w-full shrink-0 overflow-y-auto bg-white px-[15px] py-[30px] lg:block lg:w-[280px]">
      <div class="flex items-center justify-between">
        <h1 class="text-xl font-bold">チャット</h1>
        <button class="flex items-center hover:opacity-40"
          x-on:click.prevent="$dispatch('open-modal', 'view-group-create-modal')">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M12.4615 6.75C12.4615 5.23521 11.86 3.78221 10.7889 2.71109C9.71779 1.63997 8.26479 1.03846 6.75 1.03846C5.23521 1.03846 3.78221 1.63997 2.71109 2.71109C1.63997 3.78221 1.03846 5.23521 1.03846 6.75C1.03846 7.50005 1.18615 8.24282 1.47318 8.93577C1.76021 9.62871 2.18073 10.2586 2.71109 10.7889C3.24144 11.3193 3.87129 11.7398 4.56423 12.0268C5.25718 12.3138 5.99995 12.4615 6.75 12.4615C7.50005 12.4615 8.24282 12.3138 8.93577 12.0268C9.62871 11.7398 10.2586 11.3193 10.7889 10.7889C11.3193 10.2586 11.7398 9.62871 12.0268 8.93577C12.3138 8.24282 12.4615 7.50005 12.4615 6.75ZM6.23077 8.82692V7.26923H4.67308C4.38631 7.26923 4.15385 7.03676 4.15385 6.75C4.15385 6.46324 4.38631 6.23077 4.67308 6.23077H6.23077V4.67308C6.23077 4.38631 6.46324 4.15385 6.75 4.15385C7.03676 4.15385 7.26923 4.38631 7.26923 4.67308V6.23077H8.82692C9.11369 6.23077 9.34615 6.46324 9.34615 6.75C9.34615 7.03676 9.11369 7.26923 8.82692 7.26923H7.26923V8.82692C7.26923 9.11369 7.03676 9.34615 6.75 9.34615C6.46324 9.34615 6.23077 9.11369 6.23077 8.82692ZM13.5 6.75C13.5 7.63642 13.3254 8.51436 12.9862 9.33331C12.647 10.1522 12.1499 10.8964 11.5231 11.5231C10.8964 12.1499 10.1522 12.647 9.33331 12.9862C8.51436 13.3254 7.63642 13.5 6.75 13.5C5.86358 13.5 4.98564 13.3254 4.16669 12.9862C3.34781 12.647 2.60361 12.1499 1.97686 11.5231C1.35011 10.8964 0.85304 10.1522 0.513822 9.33331C0.174603 8.51436 -1.21928e-08 7.63642 0 6.75C2.66762e-08 4.95979 0.710992 3.24273 1.97686 1.97686C3.24273 0.710993 4.95979 0 6.75 0C8.54021 0 10.2573 0.710993 11.5231 1.97686C12.789 3.24273 13.5 4.95979 13.5 6.75Z"
              fill="#3289FA" />
          </svg>
          <p class="pl-[6.25px] text-sm font-bold text-[#3289FA]">グループ作成</p>
        </button>
        @livewire('chat::general.create-group')
      </div>
      @livewire('chat::general.member-list', ['selectGroup' => $selectGroup ?? null])
    </div>

    <x-main.index>
      <div class="hidden lg:block">
        <x-main.top>

        </x-main.top>
      </div>

      {{-- ------------- --}}
      <div
        class="mt-[13px] hidden h-[calc(var(--vh)*100-100px)] min-w-[1300px] flex-col rounded-[10px] bg-white p-5 shadow-[0_4px_13px_rgba(93,95,98,0.25)] lg:flex">
        <!-- 上のエリア -->
        <div class="h-[40px]">
          <div class="grid grid-cols-[50px,auto,200px]" x-data="{ showMemberList: false }">
            @if ($selectGroup->is_dm)
              @if ($selectGroup->partnerUser?->icon)
                <img class="h-10 w-10 rounded-full border bg-white"
                  src="{{ route('profile.icon', ['id' => $selectGroup->partnerUser->id]) }}" alt="アイコン">
              @else
                <div class="flex h-10 w-10 items-center justify-center rounded-full border bg-white">
                  <i class="fa-solid fa-image"></i>
                </div>
              @endif
            @else
              @if ($selectGroup->IconImage)
                <img class="h-10 w-10 rounded-full border bg-white" src="{{ $selectGroup->IconImage }}" alt="アイコン">
              @else
                <div class="flex h-10 w-10 items-center justify-center rounded-full border bg-white">
                  <i class="fa-solid fa-image"></i>
                </div>
              @endif
            @endif
            <div class="flex items-center truncate text-xl font-bold">{{ $selectGroup->NameLabel }}</div>
            @if (!$selectGroup->is_dm)
              <div class="flex items-center justify-end space-x-[10px]" @click="$dispatch('open-modal', 'view-member')">
                <div class="text-sm">{{ Auth::user()->name }}</div>
                <div class="text-xs text-[#AAB0B6]">他{{ $selectGroup->CountUser }}名</div>
                <div class="flex -space-x-3">
                  @foreach ($selectGroup->users->take(4) as $user)
                    @if ($user->icon)
                      <img class="h-8 w-8 rounded-full border bg-white"
                        src="{{ route('profile.icon', ['id' => $user->id]) }}" alt="アイコン">
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
                      @if ($user->icon)
                        <img class="h-8 w-8 rounded-full border bg-white"
                          src="{{ route('profile.icon', ['id' => $user->id]) }}" alt="アイコン">
                      @else
                        <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white">
                          <i class="fa-solid fa-image"></i>
                        </div>
                      @endif
                      <div>{{ $user->name }}</div>
                    </div>
                  @endforeach
                </div>

                <div class="flex justify-center">
                  <button class="my-4 flex items-center justify-center rounded bg-[#3289FA] px-20 py-2 text-white"
                    x-on:click="$dispatch('close-modal', 'view-member')">
                    閉じる
                  </button>
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
        <div class="min-h-[80px]">
          @vite(['Modules/Chat/resources/js/tiptap.js', 'resources/css/tiptap.css'])
          @livewire('chat::general.editor', ['group' => $selectGroup])
        </div>
      </div>

      <div class="bg-white lg:hidden">
        <div class="flex h-[50px] items-center justify-between border-b px-[14px]">
          <div class="flex items-center">
            @if ($selectGroup->is_dm)
              @if ($selectGroup->partnerUser?->icon)
                <img class="h-[30px] w-[30px] rounded-full border bg-white"
                  src="{{ route('profile.icon', ['id' => $selectGroup->partnerUser->id]) }}" alt="アイコン">
              @else
                <div class="flex h-[30px] w-[30px] items-center justify-center rounded-full border bg-white">
                  <i class="fa-solid fa-image"></i>
                </div>
              @endif
            @else
              @if ($selectGroup->IconImage)
                <img class="h-[30px] w-[30px] rounded-full border bg-white" src="{{ $selectGroup->IconImage }}"
                  alt="アイコン">
              @else
                <div class="flex h-[30px] w-[30px] items-center justify-center rounded-full border bg-white">
                  <i class="fa-solid fa-image"></i>
                </div>
              @endif
            @endif
            <div class="flex items-center truncate pl-2 text-[15px] font-bold">{{ $selectGroup->NameLabel }}</div>
          </div>
          @if (!$selectGroup->is_dm)
            <div class="flex items-center justify-end space-x-[10px]" @click="$dispatch('open-modal', 'view-member')">
              <div class="flex -space-x-3">
                @foreach ($selectGroup->users->take(4) as $user)
                  @if ($user->icon)
                    <img class="h-8 w-8 rounded-full border bg-white"
                      src="{{ route('profile.icon', ['id' => $user->id]) }}" alt="アイコン">
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
                    @if ($user->icon)
                      <img class="h-8 w-8 rounded-full border bg-white"
                        src="{{ route('profile.icon', ['id' => $user->id]) }}" alt="アイコン">
                    @else
                      <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white"><i
                          class="fa-solid fa-image"></i>
                      </div>
                    @endif
                    <div>{{ $user->name }}</div>
                  </div>
                @endforeach
              </div>

              <div class="flex justify-center">
                <button class="my-4 flex h-11 w-[150px] items-center justify-center rounded bg-[#3289FA] text-white"
                  x-on:click="$dispatch('close-modal', 'view-member')">
                  閉じる
                </button>
              </div>

            </x-modal-alert>
          @endif
        </div>
        <div class="mt-2 h-[calc(var(--vh)*100-210px)] overflow-y-auto">
          @livewire('chat::general.talk-area', ['group' => $selectGroup])
        </div>

        <!-- 下のエリア -->
        <div class="min-h-[100px]">
          @vite(['Modules/Chat/resources/js/tiptap.js', 'resources/css/tiptap.css'])
          @livewire('chat::general.editor', ['group' => $selectGroup])
        </div>
      </div>

    </x-main.index>
  </div>
</x-app-layout>
