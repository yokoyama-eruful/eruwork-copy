<x-main.index>

  <x-main.top>
    <h5 class="block text-xl font-bold sm:hidden">カレンダー</h5>
    <livewire:calendar::general.multi-create-schedule />
    <div class="hidden items-center sm:flex md:ml-0">
      <button class="flex items-center space-x-1 rounded-l pl-[30px] pr-[11px] text-[15px]"
        wire:click="clickDate('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
        <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-l.png') }}" alt="前月">
        <p class="hidden sm:block">前月</p>
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
        <p class="hidden sm:block">翌月</p>
        <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-r.png') }}" alt="翌月">
      </button>
      <div class="">
        <button class="mx-2 h-[25px] rounded border bg-[#77829C] px-2 text-[14px] text-white"
          wire:click="clickDate('{{ now()->format('Y-m-d') }}')">今月</button>
      </div>
    </div>
  </x-main.top>
  <x-main.container>
    <div class="mt-5 flex items-center justify-between px-5 sm:hidden">
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

    <h5 class="hidden text-xl font-bold sm:block">カレンダー</h5>

    <div class="mt-[25px] hidden grid-cols-7 sm:grid">
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
    </div>
    <div class="mt-[15px] hidden grid-cols-7 divide-x divide-y rounded-lg border sm:grid">
      @foreach ($this->calendar as $key => $content)
        <div @class([
            'min-h-[170px] min-w-[140px]',
            'bg-[#F9FAFF]' =>
                $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
            'bg-gray-100 hidden sm:block' => $content['type'] == '補助日',
        ]) wire:key="calendar-{{ $content['date']->format('Y-m-d') }}">

          <div class="flex items-center justify-between px-[15px]">
            <div @class([
                'text-[15px] py-[15px]',
                'font-bold text-[#3289FA]' =>
                    $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
            ])>{{ $content['date']->isoFormat('D日') }}</div>
            @if ($content['type'] != '補助日')
              {{-- スケジュール作成ボタン --}}
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
              <livewire:calendar::general.create-schedule @added="$refresh" :date="$content['date']"
                wire:key="create-schedule-desktop-{{ $content['date']->format('Y-m-d') }}" />
            @endif
          </div>

          {{-- 確定シフト表示 --}}
          @if (!empty($content['shifts']))
            <div
              class="mb-1 mr-1 min-h-[50px] min-w-[135px] rounded-lg border border-[#DE993A] bg-[#FFF7EC] p-[9px] text-[#DE993A]"
              x-cloak>
              <div class="text-[13px] font-bold">出勤</div>
              @foreach ($content['shifts'] as $shift)
                <div class="relative pt-[4px] text-xs" x-data="{ openModalShift{{ $shift->id }}: false }"
                  @click="openModalShift{{ $shift->id }}=true"
                  @click.away="openModalShift{{ $shift->id }}=false" wire:key="shift-{{ $shift->id }}">
                  <div>
                    {{ (is_null($shift->start_time) ? ' -- : -- ' : $shift->start_time->isoFormat('aH:mm')) . ' ～ ' . (is_null($shift->end_time) ? ' -- : -- ' : $shift->end_time->isoFormat('aH:mm')) }}
                  </div>
                  <div
                    class="absolute -left-4 z-10 min-w-[300px] max-w-[300px] rounded-xl bg-white py-[15px] pl-[30px] pr-[15px] shadow-[0_4px_13px_rgba(93,95,98,0.25)]"
                    x-show="openModalShift{{ $shift->id }} === true"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2">

                    <div class="flex items-center justify-between space-x-7">
                      <div class="text-xs text-[#777777]">{{ $shift->date->format('Y年m月d日') }}</div>
                      <div class="flex items-center space-x-[15px]">
                        <div class="cursor-pointer" @click.stop="openModalShift{{ $shift->id }}=false">
                          <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 15L15 5M5 5L15 15" stroke="#5E5E5E" stroke-width="1.1" stroke-linecap="round"
                              stroke-linejoin="round" />
                          </svg>
                        </div>
                      </div>
                    </div>
                    <div class="mt-[9px] truncate text-[15px] font-bold text-black">出勤</div>
                    <div class="mt-[9px] truncate text-xs text-black">
                      {{ $shift->start_time->isoFormat('aH:mm') . '～' . $shift->end_time?->isoFormat('aH:mm') }}
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif

          {{-- スケジュール表示 --}}
          @foreach ($content['schedules'] as $schedule)
            @if ($content['type'] != '補助日')
              <div @class([
                  'relative mb-1 mr-1 min-h-[50px] min-w-[135px] cursor-pointer rounded-lg border border-[#00A1FF] bg-[#F2FBFF] p-[9px] text-[#00A1FF]',
                  'mb-[23px]' => $loop->last,
              ]) x-data="{ openModalSchedule{{ $schedule->id }}: false }"
                @click="openModalSchedule{{ $schedule->id }}=true"
                @click.away="openModalSchedule{{ $schedule->id }}=false" wire:key="schedule-{{ $schedule->id }}"
                x-cloak>
                <div class="text-[13px] font-bold">
                  {{ $schedule->title }}
                </div>
                <div class="pt-[4px] text-xs">
                  {{ $schedule->start_time->isoFormat('aH:mm') . '～' . $schedule->end_time?->isoFormat('aH:mm') }}
                </div>
                <div
                  class="absolute right-0 z-10 min-w-[300px] max-w-[300px] rounded-xl bg-white py-[15px] pl-[30px] pr-[15px] shadow-[0_4px_13px_rgba(93,95,98,0.25)]"
                  x-show="openModalSchedule{{ $schedule->id }} === true"
                  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 translate-y-2"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-200"
                  x-transition:leave-start="opacity-100 translate-y-0"
                  x-transition:leave-end="opacity-0 translate-y-2">

                  <div class="flex items-center justify-between space-x-7">
                    <div class="text-xs text-[#777777]">{{ $schedule->date->format('Y年m月d日') }}</div>
                    <div class="flex items-center space-x-[15px]">
                      <div class="cursor-pointer"
                        x-on:click="$dispatch('open-modal','schedule-delete-modal-{{ $schedule->id }}')"><svg
                          width="18" height="18" viewBox="0 0 18 18" fill="none"
                          xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M11.055 6.7499L10.7955 13.4999M7.2045 13.4999L6.945 6.7499M14.421 4.3424C14.6775 4.3814 14.9325 4.42265 15.1875 4.4669M14.421 4.3424L13.62 14.7547C13.5873 15.1786 13.3958 15.5745 13.0838 15.8633C12.7717 16.1521 12.3622 16.3125 11.937 16.3124H6.063C5.63782 16.3125 5.22827 16.1521 4.91623 15.8633C4.6042 15.5745 4.41269 15.1786 4.38 14.7547L3.579 4.3424M14.421 4.3424C13.5554 4.21154 12.6853 4.11222 11.8125 4.04465M3.579 4.3424C3.3225 4.38065 3.0675 4.4219 2.8125 4.46615M3.579 4.3424C4.4446 4.21154 5.31468 4.11223 6.1875 4.04465M11.8125 4.04465V3.35765C11.8125 2.47265 11.13 1.73465 10.245 1.7069C9.41521 1.68038 8.58479 1.68038 7.755 1.7069C6.87 1.73465 6.1875 2.4734 6.1875 3.35765V4.04465M11.8125 4.04465C9.94029 3.89996 8.05971 3.89996 6.1875 4.04465"
                            stroke="#F76E80" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                      </div>
                      <div class="cursor-pointer"
                        x-on:click="$dispatch('open-modal','schedule-edit-modal-{{ $schedule->id }}')">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                          xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M1.6875 14.0623V6.18726C1.68755 5.59059 1.92477 5.01835 2.34668 4.59644C2.76863 4.17454 3.34081 3.93726 3.9375 3.93726H7.5C7.8106 3.93726 8.0624 4.18918 8.0625 4.49976C8.0625 4.81042 7.81066 5.06226 7.5 5.06226H3.9375C3.63918 5.06226 3.35306 5.18093 3.14209 5.39185C2.93116 5.60278 2.81255 5.88895 2.8125 6.18726V14.0623C2.8125 14.3606 2.93117 14.6467 3.14209 14.8577C3.35307 15.0686 3.63913 15.1873 3.9375 15.1873H11.8125C12.1109 15.1873 12.3969 15.0686 12.6079 14.8577C12.8188 14.6467 12.9375 14.3606 12.9375 14.0623V10.4998C12.9376 10.1892 13.1894 9.93726 13.5 9.93726C13.8106 9.93726 14.0624 10.1892 14.0625 10.4998V14.0623C14.0625 14.6589 13.8252 15.2311 13.4033 15.6531C12.9814 16.075 12.4092 16.3123 11.8125 16.3123H3.9375C3.34076 16.3123 2.76864 16.075 2.34668 15.6531C1.92478 15.2311 1.6875 14.6589 1.6875 14.0623ZM15.75 3.09351C15.75 2.86975 15.6614 2.65481 15.5032 2.49658C15.3449 2.33837 15.13 2.24976 14.9062 2.24976C14.6825 2.24976 14.4676 2.33837 14.3093 2.49658L13.4414 3.3645L14.6353 4.55835L15.5032 3.69043C15.6614 3.53217 15.75 3.31729 15.75 3.09351ZM12.646 4.15991L6.3457 10.4609C6.05679 10.75 5.83412 11.0981 5.69385 11.4805L5.63892 11.6467L5.33569 12.6633L6.35303 12.3608L6.51929 12.3059C6.90167 12.1657 7.24973 11.9437 7.53882 11.6548L13.8398 5.35376L12.646 4.15991ZM16.875 3.09351C16.875 3.61566 16.6678 4.1166 16.2986 4.48584L8.33423 12.4502C7.87171 12.9124 7.30126 13.2523 6.67456 13.439L4.6604 14.0388C4.46249 14.0977 4.24832 14.0435 4.10229 13.8975C3.95632 13.7514 3.90198 13.5373 3.96094 13.3394L4.56079 11.3259C4.74741 10.6991 5.08724 10.1281 5.54956 9.66553L13.5139 1.7019C13.8832 1.33272 14.3841 1.12476 14.9062 1.12476C15.4284 1.12476 15.9293 1.33198 16.2986 1.70117C16.6678 2.07037 16.875 2.57138 16.875 3.09351Z"
                            fill="#3289FA" />
                        </svg>
                      </div>
                      <div class="cursor-pointer" @click.stop="openModalSchedule{{ $schedule->id }}=false">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                          xmlns="http://www.w3.org/2000/svg">
                          <path d="M5 15L15 5M5 5L15 15" stroke="#5E5E5E" stroke-width="1.1" stroke-linecap="round"
                            stroke-linejoin="round" />
                        </svg>
                      </div>
                    </div>
                  </div>
                  <div class="mt-[9px] truncate text-[15px] font-bold text-black">{{ $schedule->title }}</div>
                  <div class="mt-[9px] truncate text-xs text-black">
                    {{ $schedule->start_time->isoFormat('aH:mm') . '～' . $schedule->end_time?->isoFormat('aH:mm') }}
                  </div>
                  @if ($schedule->description)
                    <div class="mt-[17px] break-words text-sm text-black">
                      {{ $schedule->description }}
                    </div>
                  @endif
                </div>
              </div>

              <livewire:calendar::general.edit-schedule @updated="$refresh" :$schedule
                wire:key="edit-schedule-{{ $schedule->id }}" />

              <livewire:calendar::general.delete-schedule @updated="$refresh" :$schedule
                wire:key="delete-schedule-{{ $schedule->id }}" />
            @endif
          @endforeach

        </div>
      @endforeach
    </div>

    {{-- モバイル版 --}}
    <div class="mt-[10px] block sm:hidden">
      <div class="border-b px-5 py-[10px] text-xl font-bold">{{ $selectedDate->isoFormat('M月') }}</div>
      @foreach ($this->calendar as $key => $content)
        @if ($content['type'] != '補助日')
          <div @class([
              'grid grid-cols-[15%,70%,15%] min-h-[60px]  border-b py-[10px]',
              'bg-[#F9FAFF]' => $content['date']->format('Ymd') === now()->format('Ymd'),
          ]) wire:key="calendar-{{ $content['date']->format('Y-m-d') }}">
            <div @class([
                'text-xs flex flex-col items-center justify-center',
                'font-bold text-[#3289FA]' =>
                    $content['date']->format('Ymd') === now()->format('Ymd'),
                'text-[#48CBFF]' =>
                    $content['date']->format('Ymd') !== now()->format('Ymd') &&
                    $content['date']->isoFormat('ddd') === '土',
                'text-[#FF0000]' =>
                    $content['date']->format('Ymd') !== now()->format('Ymd') &&
                    $content['date']->isoFormat('ddd') === '日',
            ])>
              <div>{{ $content['date']->isoFormat('D日') }}</div>

              <div>{{ $content['date']->isoFormat('（ddd）') }}</div>
            </div>

            <div class="flex flex-col space-y-1">
              @if (!empty($content['shifts']))
                <div
                  class="my-1 flex min-h-[50px] min-w-[255px] items-center justify-between rounded-lg border border-[#DE993A] bg-[#FFF7EC] pb-[15px] pl-5 pr-[13px] pt-3 text-[#DE993A]">
                  <div class="flex items-start text-sm font-bold">勤務時間</div>
                  @foreach ($content['shifts'] as $shift)
                    <div class="relative text-xs" x-data="{ openModalShift{{ $shift->id }}: false }"
                      @click="openModalShift{{ $shift->id }}=true"
                      @click.away="openModalShift{{ $shift->id }}=false" wire:key="shift-{{ $shift->id }}">
                      <div>
                        {{ (is_null($shift->start_time) ? ' -- : -- ' : $shift->start_time->isoFormat('aH:mm')) . ' ～ ' . (is_null($shift->end_time) ? ' -- : -- ' : $shift->end_time->isoFormat('H:mm')) }}
                      </div>
                      <div
                        class="absolute right-0 z-10 min-w-[300px] max-w-[300px] rounded-xl bg-white py-[15px] pl-[30px] pr-[15px] shadow-[0_4px_13px_rgba(93,95,98,0.25)]"
                        x-show="openModalShift{{ $shift->id }} === true"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2">

                        <div class="flex items-center justify-between space-x-7">
                          <div class="text-xs text-[#777777]">{{ $shift->date->format('Y年m月d日') }}</div>
                          <div class="flex items-center space-x-[15px]">
                            <div class="cursor-pointer" @click.stop="openModalShift{{ $shift->id }}=false">
                              <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 15L15 5M5 5L15 15" stroke="#5E5E5E" stroke-width="1.1"
                                  stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                            </div>
                          </div>
                        </div>
                        <div class="mt-[9px] truncate text-[15px] font-bold text-black">出勤</div>
                        <div class="mt-[9px] truncate text-xs text-black">
                          {{ $shift->start_time->isoFormat('aH:mm') . '～' . $shift->end_time?->isoFormat('aH:mm') }}
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif

              @foreach ($content['schedules'] as $schedule)
                @if ($content['type'] != '補助日')
                  <div @class([
                      'relative flex min-h-[50px] min-w-[255px] items-center justify-between rounded-lg border border-[#00A1FF] bg-[#F2FBFF] pb-[15px] pl-5 pr-[13px] pt-3 text-[#00A1FF]',
                  ]) x-data="{ openModalSchedule{{ $schedule->id }}: false }"
                    @click="openModalSchedule{{ $schedule->id }}=true"
                    @click.away="openModalSchedule{{ $schedule->id }}=false"
                    wire:key="schedule-{{ $schedule->id }}">
                    <div class="text-[13px] font-bold">
                      {{ $schedule->title }}
                    </div>
                    <div class="pt-[4px] text-xs">
                      {{ $schedule->start_time->isoFormat('aH:mm') . '～' . $schedule->end_time?->isoFormat('aH:mm') }}
                    </div>
                    <div
                      class="absolute -left-10 z-10 min-w-[300px] max-w-[300px] rounded-xl bg-white py-[15px] pl-[30px] pr-[15px] shadow-[0_4px_13px_rgba(93,95,98,0.25)]"
                      x-show="openModalSchedule{{ $schedule->id }} === true"
                      x-transition:enter="transition ease-out duration-300"
                      x-transition:enter-start="opacity-0 translate-y-2"
                      x-transition:enter-end="opacity-100 translate-y-0"
                      x-transition:leave="transition ease-in duration-200"
                      x-transition:leave-start="opacity-100 translate-y-0"
                      x-transition:leave-end="opacity-0 translate-y-2">

                      <div class="flex items-center justify-between space-x-7">
                        <div class="text-xs text-[#777777]">{{ $schedule->date->format('Y年m月d日') }}</div>
                        <div class="flex items-center space-x-[15px]">
                          <div class="cursor-pointer"
                            x-on:click="$dispatch('open-modal','schedule-delete-modal-{{ $schedule->id }}')"><svg
                              width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M11.055 6.7499L10.7955 13.4999M7.2045 13.4999L6.945 6.7499M14.421 4.3424C14.6775 4.3814 14.9325 4.42265 15.1875 4.4669M14.421 4.3424L13.62 14.7547C13.5873 15.1786 13.3958 15.5745 13.0838 15.8633C12.7717 16.1521 12.3622 16.3125 11.937 16.3124H6.063C5.63782 16.3125 5.22827 16.1521 4.91623 15.8633C4.6042 15.5745 4.41269 15.1786 4.38 14.7547L3.579 4.3424M14.421 4.3424C13.5554 4.21154 12.6853 4.11222 11.8125 4.04465M3.579 4.3424C3.3225 4.38065 3.0675 4.4219 2.8125 4.46615M3.579 4.3424C4.4446 4.21154 5.31468 4.11223 6.1875 4.04465M11.8125 4.04465V3.35765C11.8125 2.47265 11.13 1.73465 10.245 1.7069C9.41521 1.68038 8.58479 1.68038 7.755 1.7069C6.87 1.73465 6.1875 2.4734 6.1875 3.35765V4.04465M11.8125 4.04465C9.94029 3.89996 8.05971 3.89996 6.1875 4.04465"
                                stroke="#F76E80" stroke-width="1.2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            </svg>
                          </div>
                          <div class="cursor-pointer"
                            x-on:click="$dispatch('open-modal','schedule-edit-modal-{{ $schedule->id }}')">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M1.6875 14.0623V6.18726C1.68755 5.59059 1.92477 5.01835 2.34668 4.59644C2.76863 4.17454 3.34081 3.93726 3.9375 3.93726H7.5C7.8106 3.93726 8.0624 4.18918 8.0625 4.49976C8.0625 4.81042 7.81066 5.06226 7.5 5.06226H3.9375C3.63918 5.06226 3.35306 5.18093 3.14209 5.39185C2.93116 5.60278 2.81255 5.88895 2.8125 6.18726V14.0623C2.8125 14.3606 2.93117 14.6467 3.14209 14.8577C3.35307 15.0686 3.63913 15.1873 3.9375 15.1873H11.8125C12.1109 15.1873 12.3969 15.0686 12.6079 14.8577C12.8188 14.6467 12.9375 14.3606 12.9375 14.0623V10.4998C12.9376 10.1892 13.1894 9.93726 13.5 9.93726C13.8106 9.93726 14.0624 10.1892 14.0625 10.4998V14.0623C14.0625 14.6589 13.8252 15.2311 13.4033 15.6531C12.9814 16.075 12.4092 16.3123 11.8125 16.3123H3.9375C3.34076 16.3123 2.76864 16.075 2.34668 15.6531C1.92478 15.2311 1.6875 14.6589 1.6875 14.0623ZM15.75 3.09351C15.75 2.86975 15.6614 2.65481 15.5032 2.49658C15.3449 2.33837 15.13 2.24976 14.9062 2.24976C14.6825 2.24976 14.4676 2.33837 14.3093 2.49658L13.4414 3.3645L14.6353 4.55835L15.5032 3.69043C15.6614 3.53217 15.75 3.31729 15.75 3.09351ZM12.646 4.15991L6.3457 10.4609C6.05679 10.75 5.83412 11.0981 5.69385 11.4805L5.63892 11.6467L5.33569 12.6633L6.35303 12.3608L6.51929 12.3059C6.90167 12.1657 7.24973 11.9437 7.53882 11.6548L13.8398 5.35376L12.646 4.15991ZM16.875 3.09351C16.875 3.61566 16.6678 4.1166 16.2986 4.48584L8.33423 12.4502C7.87171 12.9124 7.30126 13.2523 6.67456 13.439L4.6604 14.0388C4.46249 14.0977 4.24832 14.0435 4.10229 13.8975C3.95632 13.7514 3.90198 13.5373 3.96094 13.3394L4.56079 11.3259C4.74741 10.6991 5.08724 10.1281 5.54956 9.66553L13.5139 1.7019C13.8832 1.33272 14.3841 1.12476 14.9062 1.12476C15.4284 1.12476 15.9293 1.33198 16.2986 1.70117C16.6678 2.07037 16.875 2.57138 16.875 3.09351Z"
                                fill="#3289FA" />
                            </svg>
                          </div>
                          <div class="cursor-pointer" @click.stop="openModalSchedule{{ $schedule->id }}=false">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path d="M5 15L15 5M5 5L15 15" stroke="#5E5E5E" stroke-width="1.1"
                                stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                          </div>
                        </div>
                      </div>
                      <div class="mt-[9px] truncate text-[15px] font-bold text-black">{{ $schedule->title }}</div>
                      <div class="mt-[9px] truncate text-xs text-black">
                        {{ $schedule->start_time->isoFormat('aH:mm') . '～' . $schedule->end_time?->isoFormat('aH:mm') }}
                      </div>
                      @if ($schedule->description)
                        <div class="mt-[17px] break-words text-sm text-black">
                          {{ $schedule->description }}
                        </div>
                      @endif
                    </div>
                  </div>

                  <livewire:calendar::general.edit-schedule @updated="$refresh" :$schedule
                    wire:key="edit-schedule-{{ $schedule->id }}-{{ $loop->index }}" />

                  <livewire:calendar::general.delete-schedule @updated="$refresh" :$schedule
                    wire:key="delete-schedule-{{ $schedule->id }}-{{ $loop->index }}" />
                @endif
              @endforeach
            </div>

            <div class="flex items-center justify-center">
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
              <livewire:calendar::general.create-schedule @added="$refresh" :date="$content['date']"
                wire:key="create-schedule-mobile-{{ $content['date']->format('Y-m-d') }}" />
            </div>

          </div>
        @endif
      @endforeach
    </div>

  </x-main.container>
</x-main.index>
