<div class="w-full justify-between lg:flex">
  <div class="w-full shrink-0 overflow-y-auto bg-white px-[15px] lg:h-[calc(var(--vh)*100)] lg:w-[280px] lg:py-[30px]"
    x-data="{ koujyoScreen: false }">
    <div class="mt-[30px] flex items-center justify-between lg:mt-0">
      <h1 class="text-xl font-bold">タイムカード</h1>
      <a class="block text-xs text-[#3289FA] focus:opacity-40 lg:hidden"
        href="{{ route('timecard.show', ['date' => $selectedDate->format('Y-m-d')]) }}"
        wire:key="{{ $selectedDate->isoFormat('Ymd') }}">扶養控除目安を確認する</a>
    </div>

    <div class="mt-[30px] flex items-center justify-between rounded bg-[#F7F7F7] py-2">
      <div class="flex flex-col items-start">
        <div class="mt-2 flex items-end justify-start ps-4 text-base font-bold">{{ $selectedDate->isoFormat('M月度') }}
        </div>
        <div class="mb-2 flex items-start justify-start ps-4 text-[11px]">勤怠時間合計</div>
      </div>
      <div class="row-span-2 flex items-center justify-end pe-[15px] text-2xl font-bold">
        {{ $totalMonthWorkingTime }}</div>
    </div>

    <div class="mb-[50px] mt-5">
      <div class="font-bold">{{ $selectedDate->isoFormat('YYYY.MM.DD（ddd曜）') }}</div>
      <div class="mt-5 text-[11px] font-bold">本日の勤務時間</div>
      @if ($workTimeList->isEmpty())
        <div
          class="mt-2 cursor-default rounded border border-[#DDDDDD] px-[15px] py-2 focus:border-[#DDDDDD] focus:ring-0">
          --:--
        </div>
      @else
        @foreach ($workTimeList as $workTime)
          <div
            class="mt-2 cursor-default rounded border border-[#DDDDDD] px-[15px] py-2 focus:border-[#DDDDDD] focus:ring-0">
            {{ $workTime->in_time?->format('H:i') }} ～ {{ $workTime->out_time?->format('H:i') }}
          </div>
        @endforeach
      @endif
      <div class="mt-5 text-[11px] font-bold">本日の休憩時間</div>
      @if ($breakTimeList->isEmpty())
        <div
          class="mt-2 cursor-default rounded border border-[#DDDDDD] px-[15px] py-2 focus:border-[#DDDDDD] focus:ring-0">
          --:--
        </div>
      @else
        @foreach ($breakTimeList as $breakTime)
          <div
            class="mt-2 cursor-default rounded border border-[#DDDDDD] px-[15px] py-2 focus:border-[#DDDDDD] focus:ring-0">
            {{ $breakTime->in_time?->format('H:i') }} ～ {{ $breakTime->out_time?->format('H:i') }}
          </div>
        @endforeach
      @endif
    </div>
    <hr class="-mx-3 border-t" />

    {{-- デスクトップ版 --}}
    <div class="hidden lg:block">
      <div class="mt-5 text-base font-bold">扶養控除目安</div>
      <div class="mt-[30px] flex items-center justify-between rounded bg-[#F7F7F7] py-2">
        <div class="flex flex-col items-start">
          <div class="mt-2 flex items-end justify-start ps-4 text-base font-bold">{{ $selectedDate->isoFormat('Y年度') }}
          </div>
          <div class="mb-2 flex items-start justify-start ps-4 text-[11px]">勤怠時間合計</div>
        </div>
        <div class="row-span-2 flex items-center justify-end pe-[15px] text-2xl font-bold">
          {{ $totalYearWorkingTime }}</div>
      </div>
      <div class="mt-5 text-sm font-bold">扶養控除ラインと現在の収入の比較</div>
      <div class="mt-[10px]">
        <div class="-mx-[15px] grid grid-cols-8 text-[10px] text-[#777777]">
          <div class="text-center">0</div>
          <div class="text-center">25</div>
          <div class="text-center">50</div>
          <div class="text-center">75</div>
          <div class="text-center">100</div>
          <div class="text-center">125</div>
          <div class="text-center">150</div>
          <div class="text-center">万円</div>
        </div>
        <div class="relative grid h-[180px] grid-cols-7 overflow-hidden rounded border">
          <!-- グリッド背景 -->
          <div class="border-r"></div>
          <div class="border-r"></div>
          <div class="border-r"></div>
          <div class="border-r"></div>
          <div class="border-r"></div>
          <div class="border-r"></div>
          <div></div>

          <div class="absolute left-0 top-[70px] h-9 rounded-r bg-[#6ed0f7] transition-all duration-1000 ease-out"
            x-data="{ width: '0%' }" x-init="setTimeout(() => { width = '{{ $this->barWidth() }}' }, 50)" :style="'width:' + width">
          </div>

          <div
            class="absolute top-10 z-[6] whitespace-nowrap rounded bg-white py-1 pl-[6px] pr-[10px] text-xs font-bold shadow-[0_4px_13px_0_#5D5F6240] transition-[left] duration-1000 ease-out"
            style="left: {{ $this->barWidth() }}; transform: translateX(8px);">
            {{ number_format($totalYearPay) }}円
          </div>

          <hr
            class="absolute left-[58.86%] top-0 z-[5] h-[calc(100%+10px)] border-r-[1.5px] border-dashed border-[#FF4A62]" />

        </div>

      </div>
      <div class="mt-[56px]">
        <div class="text-xs font-bold">あなたの時給から扶養控除目安を算出</div>
        <div class="mt-3 flex flex-col space-y-2">
          <div class="flex items-center justify-between rounded bg-[#F7F7F7] px-[10px] py-[20px]">
            <div class="text-sm font-bold">106万</div>
            <div class="flex items-center space-x-[2px]">
              <div class="text-sm font-bold text-[#FF4A62]">{{ number_format(1060000 - $totalYearPay) }}</div>
              <div class="text-xs">円以上で超過</div>
            </div>
          </div>
          <div class="flex items-center justify-between rounded bg-[#F7F7F7] px-[10px] py-[20px]">
            <div class="text-sm font-bold">130万</div>
            <div class="flex items-center space-x-[2px]">
              <div class="text-sm font-bold text-[#FF4A62]">{{ number_format(1300000 - $totalYearPay) }}</div>
              <div class="text-xs">円以上で超過</div>
            </div>
          </div>
          <div class="flex items-center justify-between rounded bg-[#F7F7F7] px-[10px] py-[20px]">
            <div class="text-sm font-bold">150万</div>
            <div class="flex items-center space-x-[2px]">
              <div class="text-sm font-bold text-[#FF4A62]">{{ number_format(1500000 - $totalYearPay) }}</div>
              <div class="text-xs">円以上で超過</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- デスクトップ版メイン --}}
  <x-main.index class="hidden lg:block">
    <x-main.top>
      <div class="flex items-center md:ml-0">
        <button class="hidden items-center space-x-1 rounded-l text-[15px] xl:px-4 tablet:flex"
          wire:click="selectedMonth('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
          <img class="h-[18px] w-[18px]" src="{{ asset('img/icon/arrow-l.png') }}" alt="前月">
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
        <button class="hidden items-center space-x-1 rounded-r text-[15px] xl:px-4 tablet:flex"
          wire:click="selectedMonth('{{ $selectedDate->addMonth()->format('Y-m-d') }}')">
          <p class="hidden lg:block">翌月</p>
          <img class="h-[18px] w-[18px]" src="{{ asset('img/icon/arrow-r.png') }}" alt="翌月">
        </button>
        <div class="">
          <button class="mx-[15px] h-[30px] rounded border bg-[#77829C] px-3 text-[14px] text-white"
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
              'min-h-[170px]',
              'bg-[#F9FAFF]' =>
                  $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
              'bg-gray-100 hidden lg:block' => $content['type'] == '補助日',
          ]) wire:click="clickDate('{{ $content['date'] }}')"
            wire:key="calendar-box-{{ $content['date']->format('Y-m-d') }}">
            <div @class([
                'pl-[15px] text-[15px] py-[15px]',
                'font-bold text-[#3289FA]' =>
                    $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
            ])>{{ $content['date']->isoFormat('D日') }}</div>

            @if ($content['workTimes']->isNotEmpty())
              <div
                class="mb-[19px] mr-1 min-h-[108px] rounded-lg border border-[#00A1FF] bg-[#F2FBFF] p-[9px] text-[#00A1FF]">
                <div class="text-[13px] font-bold">勤務時間</div>
                @foreach ($content['workTimes'] as $key => $time)
                  <div class="pt-[4px] text-xs">
                    {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->isoFormat('H:mm')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->isoFormat('H:mm')) }}
                  </div>
                @endforeach
                <div class="my-[10px] border-t border-[#00A1FF]"></div>
                <div class="text-[13px] font-bold">休憩時間</div>
                @if ($content['breakTimes']->isEmpty())
                  <div class="pt-[4px] text-xs">休憩なし</div>
                @else
                  @foreach ($content['breakTimes'] as $key => $time)
                    <div class="pt-[4px] text-xs">
                      {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->isoFormat('H:mm')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->isoFormat('H:mm')) }}
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
  <div class="block px-[15px] pb-[30px] pt-[50px] lg:hidden">
    <div class="flex items-center justify-center space-x-[22px] md:ml-0">
      <button class="flex items-center rounded-l text-[15px]"
        wire:click="selectedMonth('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
        <img class="h-[18px] w-[18px]" src="{{ asset('img/icon/arrow-l.png') }}" alt="前月">
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
        <img class="h-[18px] w-[18px]" src="{{ asset('img/icon/arrow-r.png') }}" alt="翌月">
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
            ])>{{ $content['date']->isoFormat('D日（ddd曜）') }}</div>

            @if ($content['workTimes']->isNotEmpty())
              <div class="my-2 min-w-[256px] rounded-lg border border-[#DE993A] bg-[#FFF7EC] p-[9px] text-[#DE993A]">
                <div class="flex flex-row items-start space-x-[37px]">
                  <div class="text-xs font-bold">勤務時間</div>
                  <div class="flex flex-col">
                    @foreach ($content['workTimes'] as $key => $time)
                      <div class="text-xs font-bold">
                        {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->isoFormat('H:mm')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->isoFormat('H:mm')) }}
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
                          {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->isoFormat('H:mm')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->isoFormat('H:mm')) }}
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
