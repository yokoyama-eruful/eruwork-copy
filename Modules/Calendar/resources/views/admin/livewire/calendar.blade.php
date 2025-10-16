{{-- <div>
  <div class="mb-2 flex flex-wrap items-center justify-between">
    <div class="flex items-center md:ml-0">
      <button
        class="flex h-10 items-center space-x-1 rounded-l bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
        wire:click="clickDate('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
        <i class="fa-solid fa-chevron-left"></i>
        <p class="hidden lg:block">前月</p>
      </button>
      <div class="flex flex-row">
        <select class="h-10" wire:model.live="year" wire:change="updateCalendar">
          @foreach (range(2000, 2050) as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="h-10" wire:model.live="month" wire:change="updateCalendar">
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
      </div>
      <button
        class="flex h-10 items-center space-x-1 rounded-r bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
        wire:click="clickDate('{{ $selectedDate->addMonth()->format('Y-m-d') }}')">
        <p class="hidden lg:block">翌月</p>
        <i class="fa-solid fa-chevron-right"></i>
      </button>
      <div class="h-10">
        <button class="mx-2 h-10 rounded border bg-ao-sub px-2 hover:bg-ao-main"
          wire:click="clickDate('{{ now()->format('Y-m-d') }}')">今月</button>
      </div>
    </div>
    <livewire:calendar::admin.multi-create-public-holiday />
  </div>

  <div class="items-center overflow-x-auto">
    <div class="hidden w-full grid-cols-7 border lg:grid">
      <div class="border-x bg-gray-300 text-center text-gray-800">月</div>
      <div class="border-x bg-gray-300 text-center text-gray-800">火</div>
      <div class="border-x bg-gray-300 text-center text-gray-800">水</div>
      <div class="border-x bg-gray-300 text-center text-gray-800">木</div>
      <div class="border-x bg-gray-300 text-center text-gray-800">金</div>
      <div class="border-x bg-sky-200 text-center text-gray-800">土</div>
      <div class="border-x bg-red-200 text-center text-gray-800">日</div>
    </div>

    <div class="grid w-full lg:grid-cols-7" wire:key="calendar-grid">
      @foreach ($this->calendar as $key => $content)
        <div @class([
            'flex flex-col min-h-20 border',
            'bg-sky-100' => $content['type'] == '土曜日',
            'bg-red-100' => $content['type'] == '日曜日',
            'bg-orange-200' => $content['type'] == '公休日',
            'bg-gray-100 hidden lg:block' => $content['type'] == '補助日',
        ]) wire:key="calendar-box-{{ $content['date']->format('Y-m-d') }}">
          <div class="mx-1 flex items-center justify-between">
            @if ($content['type'] != '補助日')
              <div>
                @if ($content['date']->day == 1 || $key == 1)
                  {{ $content['date']->isoFormat('Y年M月D日') }}
                @else
                  {{ $content['date']->isoFormat('D日') }}
                @endif
              </div>
              @if (!$content['holiday'])
                <button class="text-2xl opacity-30 hover:text-ao-main hover:opacity-100 xl:text-xl" type="button"
                  x-on:click="$dispatch('open-modal', 'create-modal-{{ $content['date']->format('Y-m-d') }}')">
                  <i class="fa-regular fa-square-plus"></i>
                </button>
              @endif
            @endif
          </div>
          @if ($content['holiday'])
            <button class="text-center text-xl font-medium hover:text-ao-main" type="button"
              x-on:click="$dispatch('open-modal', 'edit-modal-{{ $content['holiday']->id }}')">{{ $content['holiday']->name }}</button>
            <livewire:calendar::admin.edit-public-holiday @updated="$refresh" :publicHoliday="$content['holiday']" :key="$content['holiday']->id . '-' . $selectedDate->format('Ymd')" />
          @endif
        </div>

        @if ($content['type'] != '補助日')
          <livewire:calendar::admin.create-public-holiday @added="$refresh" :date="$content['date']" :key="$content['date']->format('Ymd') . $key" />
        @endif
      @endforeach
    </div>
  </div> --}}

<x-dashboard.index>

  <x-dashboard.top>
    <h5 class="block text-xl font-bold lg:hidden">カレンダー</h5>
    <livewire:calendar::admin.multi-create-public-holiday />
    <div class="hidden items-center md:ml-0 lg:flex">
      <button class="flex items-center space-x-1 rounded-l pl-[30px] pr-[11px] text-[15px]"
        wire:click="clickDate('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
        <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-l.png') }}" alt="前月">
        <p class="hidden lg:block">前月</p>
      </button>
      <div class="flex flex-row space-x-[5px]">
        <select class="rounded border border-[#DDDDDD]" wire:model.live="year" wire:change="updateCalendar">
          @foreach (range(2000, 2050) as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="rounded border border-[#DDDDDD]" wire:model.live="month" wire:change="updateCalendar">
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
      </div>
      <button class="flex items-center space-x-1 rounded-r pl-[11px] text-[15px]"
        wire:click="clickDate('{{ $selectedDate->addMonth()->format('Y-m-d') }}')">
        <p class="hidden lg:block">翌月</p>
        <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-r.png') }}" alt="翌月">
      </button>
      <div class="">
        <button class="mx-5 h-[35px] rounded border bg-[#77829C] px-2 text-[14px] text-white"
          wire:click="clickDate('{{ now()->format('Y-m-d') }}')">今月</button>
      </div>
    </div>
  </x-dashboard.top>
  <x-dashboard.container>
    <div class="mt-5 flex items-center justify-between px-5 lg:hidden">
      <button class="flex items-center space-x-1 rounded-l text-[15px]"
        wire:click="clickDate('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
        <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-l.png') }}" alt="前月">
        <p class="text-[15px]">前月</p>
      </button>
      <div class="flex flex-row space-x-[5px]">
        <select class="w-[115px] rounded border border-[#DDDDDD]" wire:model.live="year" wire:change="updateCalendar">
          @foreach (range(2000, 2050) as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="w-[96px] rounded border border-[#DDDDDD]" wire:model.live="month" wire:change="updateCalendar">
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
      </div>
      <button class="flex items-center space-x-1 rounded-r text-[15px]"
        wire:click="clickDate('{{ $selectedDate->addMonth()->format('Y-m-d') }}')">
        <p class="text-[15px]">翌月</p>
        <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-r.png') }}" alt="翌月">
      </button>
    </div>

    <h5 class="hidden text-xl font-bold lg:block">公休日登録</h5>

    <div class="mt-[25px] hidden grid-cols-7 lg:grid">
      <div class="flex items-center justify-between">
        <div class="text-xl font-bold">{{ $selectedDate->isoFormat('M月') }}</div>
        <div class="text-[15px]">月</div>
        <div></div>
      </div>
      <div class="flex items-center justify-center text-[15px]">火</div>
      <div class="flex items-center justify-center text-[15px]">水</div>
      <div class="flex items-center justify-center text-[15px]">木</div>
      <div class="flex items-center justify-center text-[15px]">金</div>
      <div class="flex items-center justify-center text-[15px] text-[#48CBFF]">土</div>
      <div class="flex items-center justify-center text-[15px] text-[#FF0000]">日</div>
      {{-- <div class="text-xl font-bold">{{ $selectedDate->isoFormat('M月') }}</div> --}}
    </div>
    <div class="mt-[15px] hidden grid-cols-7 divide-x divide-y rounded-lg border lg:grid">
      @foreach ($this->calendar as $key => $content)
        <div @class([
            'min-h-[170px] min-w-[140px]',
            'bg-[#F9FAFF]' =>
                $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
            'bg-gray-100 hidden lg:block' => $content['type'] == '補助日',
        ]) wire:key="calendar-{{ $content['date']->format('Y-m-d') }}">

          <div class="flex items-center justify-between px-[15px]">
            <div @class([
                'text-[15px] py-[15px]',
                'font-bold text-[#3289FA]' =>
                    $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
            ])>{{ $content['date']->isoFormat('D日') }}</div>
            @if ($content['type'] != '補助日')
              @if (!$content['holiday'])
                <div>
                  <button class="hover:opacity-40" type="button"
                    x-on:click="$dispatch('open-modal', 'create-modal-{{ $content['date']->format('Y-m-d') }}')">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M9 6.5V11.5M11.5 9H6.5M16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                        stroke="#3289FA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </button>
                </div>

                <livewire:calendar::admin.create-public-holiday @added="$refresh" :date="$content['date']" :key="$content['date']->format('Ymd') . $key" />
              @endif
            @endif
          </div>
          @if ($content['holiday'])
            <div
              class="mr-[1px] h-[115px] cursor-pointer rounded-lg bg-[#FFF3F5] px-[10px] py-[17px] outline outline-1 outline-[#FF4A62]"
              type="button" x-on:click="$dispatch('open-modal', 'edit-modal-{{ $content['holiday']->id }}')">
              <div class="flex items-center space-x-[6px]">
                <div class="flex h-[22px] w-[22px] items-center justify-center rounded bg-[#FF4A62] text-xs text-white">
                  定
                </div>
                <div class="break-words font-bold text-[#FF4A62]">{{ $content['holiday']->name }}</div>
              </div>
            </div>
            <livewire:calendar::admin.edit-public-holiday @updated="$refresh" :publicHoliday="$content['holiday']" :key="$content['holiday']->id . '-' . $selectedDate->format('Ymd')" />
          @endif
        </div>
      @endforeach
    </div>

    {{-- モバイル版 --}}
    <div class="mt-[10px] block lg:hidden">
      <div class="border-b px-5 py-[10px] text-xl font-bold">{{ $selectedDate->isoFormat('M月') }}</div>
      @foreach ($this->calendar as $key => $content)
        @if ($content['type'] != '補助日')
          <div @class([
              'flex min-h-[60px] items-center justify-between border-b px-5 py-[10px]',
              'bg-[#F9FAFF]' => $content['date']->format('Ymd') === now()->format('Ymd'),
          ]) wire:key="calendar-{{ $content['date']->format('Y-m-d') }}">
            <div @class([
                'text-xs',
                'font-bold text-[#3289FA]' =>
                    $content['date']->format('Ymd') === now()->format('Ymd'),
                'text-[#48CBFF]' =>
                    $content['date']->format('Ymd') !== now()->format('Ymd') &&
                    $content['date']->isoFormat('ddd') === '土',
                'text-[#FF0000]' =>
                    $content['date']->format('Ymd') !== now()->format('Ymd') &&
                    $content['date']->isoFormat('ddd') === '日',
            ])>{{ $content['date']->isoFormat('D日（ddd曜）') }}</div>

          </div>
        @endif
      @endforeach
    </div>

  </x-dashboard.container>
</x-dashboard.index>
