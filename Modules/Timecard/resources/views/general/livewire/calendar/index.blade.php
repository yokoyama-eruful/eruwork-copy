<div class="w-full justify-between sm:flex">
  <div class="w-full shrink-0 overflow-y-auto bg-white px-[15px] sm:w-[280px] sm:py-[30px]" x-data="{ koujyoScreen: false }">
    <div class="mt-[30px] flex items-center justify-between sm:mt-0">
      <h1 class="text-xl font-bold">タイムカード</h1>
      <button class="block text-xs text-[#3289FA] focus:opacity-40 sm:hidden" type="button"
        x-on:click="koujyoScreen = true">扶養控除目安を確認する</button>
    </div>

    <div class="mt-[30px] flex items-center justify-between rounded bg-[#F7F7F7] py-2">
      <div class="flex flex-col items-start">
        <div class="flex items-end justify-start ps-4 text-base font-bold">{{ $selectedDate->isoFormat('M月度') }}</div>
        <div class="flex items-start justify-start ps-4 text-[11px]">勤怠時間合計</div>
      </div>
      <div class="row-span-2 flex items-center justify-end pe-[15px] text-2xl font-bold">
        {{ $totalMonthWorkingTime }}</div>
    </div>

    <div class="mb-[50px] mt-5">
      <div class="font-bold">{{ $selectedDate->isoFormat('Y年M月D日（ddd曜日）') }}</div>
      <div class="mt-5 text-[11px] font-bold">本日の勤務時間</div>
      @if ($workTimeList->isEmpty())
        <div
          class="mt-2 cursor-default rounded border border-[#DDDDDD] px-[15px] py-3 focus:border-[#DDDDDD] focus:ring-0">
          --:--
        </div>
      @else
        @foreach ($workTimeList as $workTime)
          <div
            class="mt-2 cursor-default rounded border border-[#DDDDDD] px-[15px] py-3 focus:border-[#DDDDDD] focus:ring-0">
            {{ $workTime->in_time?->format('H:i') }} ～ {{ $workTime->out_time?->format('H:i') }}
          </div>
        @endforeach
      @endif
      <div class="mt-5 text-[11px] font-bold">本日の休憩時間</div>
      @if ($breakTimeList->isEmpty())
        <div
          class="mt-2 cursor-default rounded border border-[#DDDDDD] px-[15px] py-3 focus:border-[#DDDDDD] focus:ring-0">
          --:--
        </div>
      @else
        @foreach ($breakTimeList as $breakTime)
          <div
            class="mt-2 cursor-default rounded border border-[#DDDDDD] px-[15px] py-3 focus:border-[#DDDDDD] focus:ring-0">
            {{ $breakTime->in_time?->format('H:i') }} ～ {{ $breakTime->out_time?->format('H:i') }}
          </div>
        @endforeach
      @endif
    </div>
    <hr class="-mx-3 border-t" />

    {{-- デスクトップ版 --}}
    <div class="hidden sm:block">
      <div class="mt-5 text-base font-bold">扶養控除目安</div>
      <div class="mt-[30px] flex items-center justify-between rounded bg-[#F7F7F7] py-2">
        <div class="flex flex-col items-start">
          <div class="flex items-end justify-start ps-4 text-base font-bold">{{ $selectedDate->isoFormat('Y年度') }}</div>
          <div class="flex items-start justify-start ps-4 text-[11px]">勤怠時間合計</div>
        </div>
        <div class="row-span-2 flex items-center justify-end pe-[15px] text-2xl font-bold">
          {{ $totalYearWorkingTime }}</div>
      </div>
      <div class="mt-5 text-sm font-bold">現在の進捗状況</div>
      {{-- 進捗状況に関しては後程作る --}}
    </div>

    {{-- モバイル版 --}}
    <div class="fixed inset-x-0 bottom-0 top-[50px] z-10 block bg-white px-[15px] pt-[30px] sm:hidden"
      x-show="koujyoScreen===true" x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
      x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0"
      x-transition:leave-end="opacity-0 translate-x-full">
      <div class="flex items-center hover:opacity-40" x-on:click="koujyoScreen = false">
        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M0.182788 7.30568C0.0657455 7.18931 0 7.03157 0 6.86711C0 6.70264 0.0657455 6.5449 0.182788 6.42853L6.43279 0.222234C6.55127 0.112606 6.70797 0.0529239 6.86989 0.0557607C7.03181 0.0585976 7.1863 0.123732 7.30081 0.237442C7.41532 0.351152 7.48091 0.50456 7.48377 0.665345C7.48662 0.82613 7.42652 0.98174 7.31612 1.09939L1.50779 6.86711L7.31612 12.6348C7.37753 12.6916 7.42678 12.7602 7.46094 12.8363C7.4951 12.9124 7.51347 12.9946 7.51495 13.0779C7.51643 13.1613 7.50099 13.244 7.46956 13.3213C7.43812 13.3986 7.39134 13.4688 7.33199 13.5277C7.27264 13.5867 7.20194 13.6331 7.12412 13.6643C7.0463 13.6956 6.96294 13.7109 6.87902 13.7094C6.7951 13.7079 6.71234 13.6897 6.63567 13.6558C6.55901 13.6219 6.49001 13.573 6.43279 13.512L0.182788 7.30568Z"
            fill="#3289FA" />
        </svg>
        <div class="ml-1 text-xl font-bold">扶養控除目安</div>
      </div>

      <div class="mt-[30px] flex items-center justify-between rounded bg-[#F7F7F7] py-2">
        <div class="flex flex-col items-start">
          <div class="flex items-end justify-start ps-4 text-base font-bold">{{ $selectedDate->isoFormat('Y年度') }}</div>
          <div class="flex items-start justify-start ps-4 text-[11px]">勤怠時間合計</div>
        </div>
        <div class="row-span-2 flex items-center justify-end pe-[15px] text-2xl font-bold">
          {{ $totalYearWorkingTime }}
        </div>
      </div>

      <div class="mt-5 text-sm font-bold">現在の進捗状況</div>
      {{-- 進捗状況に関しては後程作る --}}
    </div>

  </div>

  {{-- デスクトップ版メイン --}}
  <x-main.index class="hidden sm:block">
    <x-main.top>
      <div class="flex items-center md:ml-0">
        <button class="flex items-center space-x-1 rounded-l text-[15px] xl:px-2"
          wire:click="selectedMonth('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
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
        <button class="flex items-center space-x-1 rounded-r text-[15px] xl:px-2"
          wire:click="selectedMonth('{{ $selectedDate->addMonth()->format('Y-m-d') }}')">
          <p class="hidden sm:block">翌月</p>
          <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-r.png') }}" alt="翌月">
        </button>
        <div class="">
          <button class="mx-2 h-[25px] rounded border bg-[#77829C] px-2 text-xs text-white"
            wire:click="selectedMonth('{{ now()->format('Y-m-d') }}')">今月</button>
        </div>
      </div>
    </x-main.top>
    <x-main.container>
      <div class="grid grid-cols-7">
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
      <div class="mt-[15px] grid grid-cols-7 divide-x divide-y rounded-lg border">
        @foreach ($this->calendar as $content)
          <div @class([
              'min-h-[170px] min-w-[140px]',
              'bg-[#F9FAFF]' =>
                  $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
              'bg-gray-100 hidden sm:block' => $content['type'] == '補助日',
          ]) wire:click="clickDate('{{ $content['date'] }}')"
            wire:key="calendar-box-{{ $content['date']->format('Y-m-d') }}">
            <div @class([
                'pl-[15px] text-[15px] py-[15px]',
                'font-bold text-[#3289FA]' =>
                    $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
            ])>{{ $content['date']->isoFormat('D日') }}</div>

            @if ($content['workTimes']->isNotEmpty())
              <div
                class="mb-[19px] mr-1 min-h-[108px] min-w-[135px] rounded-lg border border-[#DE993A] bg-[#FFF7EC] p-[9px] text-[#DE993A]">
                <div class="text-[13px] font-bold">勤務時間</div>
                @foreach ($content['workTimes'] as $key => $time)
                  <div class="pt-[4px] text-xs">
                    {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->isoFormat('aH:mm')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->isoFormat('aH:mm')) }}
                  </div>
                @endforeach
                <div class="my-[10px] border-t border-[#DE993A]"></div>
                <div class="text-[13px] font-bold">休憩時間</div>
                @if ($content['breakTimes']->isEmpty())
                  <div class="pt-[4px] text-xs">休憩なし</div>
                @else
                  @foreach ($content['breakTimes'] as $key => $time)
                    <div class="pt-[4px] text-xs">
                      {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->isoFormat('aH:mm')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->isoFormat('aH:mm')) }}
                    </div>
                  @endforeach
                @endif
              </div>
            @endif
          </div>
        @endforeach
      </div>
    </x-main.container>
  </x-main.index>

  {{-- モバイル版メイン --}}
  <div class="block px-[15px] pt-[50px] sm:hidden">
    <div class="flex items-center justify-center space-x-[22px] md:ml-0">
      <button class="flex items-center rounded-l text-[15px]"
        wire:click="selectedMonth('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
        <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-l.png') }}" alt="前月">
        <p class="text-[15px] text-[#5E5E5E]">前月</p>
      </button>
      <div class="flex h-[35px] flex-row space-x-[5px]">
        <select class="w-[115px] rounded border border-[#DDDDDD] p-0 px-[11px]" wire:model.live="year"
          wire:change="updateCalendar">
          @foreach (range(2000, 2050) as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="w-[96px] rounded border border-[#DDDDDD] p-0 px-[11px]" wire:model.live="month"
          wire:change="updateCalendar">
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
      </div>
      <button class="flex items-center rounded-r text-[15px]"
        wire:click="selectedMonth('{{ $selectedDate->addMonth()->format('Y-m-d') }}')">
        <p class="text-[15px] text-[#5E5E5E]">翌月</p>
        <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-r.png') }}" alt="翌月">
      </button>
    </div>
    <div class="mt-5 text-xl font-bold">{{ $selectedDate->isoFormat('M月') }}</div>
    <div class="-mx-[15px]">
      @foreach ($this->calendar as $content)
        @if ($content['type'] !== '補助日')
          <div @class([
              'flex min-h-[78px] h-auto items-center justify-between border-y px-4',
              'bg-[#F9FAFF]' =>
                  $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
          ]) wire:click="clickDate('{{ $content['date'] }}')"
            wire:key="mobile-calendar-box-{{ $content['date']->format('Y-m-d') }}">
            <div @class([
                'text-xs',
                'text-[#3289FA] font-bold' =>
                    $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
                'text-[#48CBFF]' =>
                    $content['date']->format('Y-m-d') !== $selectedDate->format('Y-m-d') &&
                    $content['date']->isoFormat('ddd') === '土',
                'text-[#FF0000]' =>
                    $content['date']->format('Y-m-d') !== $selectedDate->format('Y-m-d') &&
                    $content['date']->isoFormat('ddd') === '日',
            ])>{{ $content['date']->isoFormat('D日（ddd曜日）') }}</div>

            @if ($content['workTimes']->isNotEmpty())
              <div class="my-2 min-w-[256px] rounded-lg border border-[#DE993A] bg-[#FFF7EC] p-[9px] text-[#DE993A]">
                <div class="flex flex-row items-start space-x-[37px]">
                  <div class="text-xs font-bold">勤務時間</div>
                  <div class="flex flex-col">
                    @foreach ($content['workTimes'] as $key => $time)
                      <div class="text-xs font-bold">
                        {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->isoFormat('aH:mm')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->isoFormat('aH:mm')) }}
                      </div>
                    @endforeach
                  </div>
                </div>
                <div class="mt-[7px] flex flex-row items-start space-x-[37px]">
                  <div class="text-xs font-bold">休憩時間</div>
                  <div class="flex flex-col">
                    @if ($content['breakTimes']->isEmpty())
                      <div class="text-xs font-bold">休憩なし</div>
                    @else
                      @foreach ($content['breakTimes'] as $key => $time)
                        <div class="text-xs font-bold">
                          {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->isoFormat('aH:mm')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->isoFormat('aH:mm')) }}
                        </div>
                      @endforeach
                    @endif
                  </div>
                </div>
              </div>
            @endif
          </div>
        @endif
      @endforeach
    </div>
  </div>
</div>
