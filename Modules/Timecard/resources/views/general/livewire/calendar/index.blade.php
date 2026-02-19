<div class="w-full justify-between lg:flex">
  <div class="w-full shrink-0 overflow-y-auto bg-white px-[15px] lg:h-[calc(var(--vh)*100)] lg:w-[280px] lg:py-[30px]"
    x-data="{ koujyoScreen: false }">
    <div class="mt-[30px] flex items-center justify-between lg:mt-0">
      <h1 class="text-xl font-bold">タイムカード</h1>
      <a class="block text-xs font-bold text-[#3289FA] focus:opacity-40 lg:hidden"
        href="{{ route('timecard.show', ['date' => $selectedDate->format('Y-m-d')]) }}"
        wire:key="{{ $selectedDate->isoFormat('Ymd') }}">税金の壁到達目安を確認する</a>
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
      <div class="font-bold">{{ $selectedDate->isoFormat('YYYY/MM/DD（ddd曜）') }}</div>
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
      <div class="mt-5 text-base font-bold">
        <div class="flex flex-col hover:opacity-40">
          <div class="ml-2 text-lg">税金の壁到達目安</div>
          <div class="text-xs">（扶養控除）</div>
        </div>
      </div>
      <div class="mt-[30px] flex items-center justify-between rounded bg-[#F7F7F7] py-2">
        <div class="flex flex-col items-start">
          <div class="mt-2 flex items-end justify-start ps-4 text-base font-bold">{{ $selectedDate->isoFormat('Y年度') }}
          </div>
          <div class="mb-2 flex items-start justify-start ps-4 text-[11px]">勤怠時間合計</div>
        </div>
        <div class="row-span-2 flex items-center justify-end pe-[15px] text-2xl font-bold">
          {{ $totalYearWorkingTime }}</div>
      </div>
      <div class="mt-5 text-sm font-bold">税金の壁と現在の収入の比較</div>
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

          <div class="absolute left-0 top-[70px] h-9 rounded-r bg-[#6ed0f7]" style="width: {{ $this->barWidth }};">
          </div>

          <div
            class="absolute top-10 z-[6] whitespace-nowrap rounded bg-white py-1 pl-[6px] pr-[10px] text-xs font-bold shadow-[0_4px_13px_0_#5D5F6240]"
            style="left: {{ $this->barWidth }}; transform: translateX(8px);">
            {{ number_format($totalYearPay) }}円
          </div>
          <hr
            class="absolute left-[58.86%] top-0 z-[5] h-[calc(100%+10px)] border-r-[1.5px] border-dashed border-[#FF4A62]" />
        </div>
        {{-- <div class="mt-3 w-full">
          <div class="flex items-center justify-center text-xs text-[#3289FA]">
            <button class="flex items-center justify-center space-x-1 hover:opacity-40">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M12.4615 6.75C12.4615 5.23521 11.86 3.78221 10.7889 2.71109C9.71779 1.63997 8.26479 1.03846 6.75 1.03846C5.23521 1.03846 3.78221 1.63997 2.71109 2.71109C1.63997 3.78221 1.03846 5.23521 1.03846 6.75C1.03846 7.50005 1.18615 8.24282 1.47318 8.93577C1.76021 9.62871 2.18073 10.2586 2.71109 10.7889C3.24144 11.3193 3.87129 11.7398 4.56423 12.0268C5.25718 12.3138 5.99995 12.4615 6.75 12.4615C7.50005 12.4615 8.24282 12.3138 8.93577 12.0268C9.62871 11.7398 10.2586 11.3193 10.7889 10.7889C11.3193 10.2586 11.7398 9.62871 12.0268 8.93577C12.3138 8.24282 12.4615 7.50005 12.4615 6.75ZM6.23077 8.82692V7.26923H4.67308C4.38631 7.26923 4.15385 7.03676 4.15385 6.75C4.15385 6.46324 4.38631 6.23077 4.67308 6.23077H6.23077V4.67308C6.23077 4.38631 6.46324 4.15385 6.75 4.15385C7.03676 4.15385 7.26923 4.38631 7.26923 4.67308V6.23077H8.82692C9.11369 6.23077 9.34615 6.46324 9.34615 6.75C9.34615 7.03676 9.11369 7.26923 8.82692 7.26923H7.26923V8.82692C7.26923 9.11369 7.03676 9.34615 6.75 9.34615C6.46324 9.34615 6.23077 9.11369 6.23077 8.82692ZM13.5 6.75C13.5 7.63642 13.3254 8.51436 12.9862 9.33331C12.647 10.1522 12.1499 10.8964 11.5231 11.5231C10.8964 12.1499 10.1522 12.647 9.33331 12.9862C8.51436 13.3254 7.63642 13.5 6.75 13.5C5.86358 13.5 4.98564 13.3254 4.16669 12.9862C3.34781 12.647 2.60361 12.1499 1.97686 11.5231C1.35011 10.8964 0.85304 10.1522 0.513822 9.33331C0.174603 8.51436 -1.21928e-08 7.63642 0 6.75C2.66762e-08 4.95979 0.710992 3.24273 1.97686 1.97686C3.24273 0.710993 4.95979 0 6.75 0C8.54021 0 10.2573 0.710993 11.5231 1.97686C12.789 3.24273 13.5 4.95979 13.5 6.75Z"
                  fill="#3289FA" />
              </svg>
              <p>未登録の給与分を追加</p>
            </button>
          </div>
          <div class="mt-3 flex items-center justify-between rounded bg-[#F7F7F7] p-3 text-xs">
            <div class="flex items-center">
              <p class="font-bold">登録した給与分:</p>
              <p class="text-base font-bold">800,000</p>
            </div>
            <button class="text-[#3289FA] hover:opacity-40">変更</button>
          </div>
        </div> --}}
      </div>
      <div class="mt-[56px]">
        <div class="text-xs font-bold">あなたの時給から税金の壁を算出</div>
        <div class="mt-3 flex flex-col space-y-2">
          <div class="flex items-center justify-between rounded bg-[#F7F7F7] px-[10px] py-[20px]">
            <div class="text-sm font-bold">123万</div>
            <div class="flex items-center space-x-[2px]">
              <div class="text-sm font-bold text-[#FF4A62]">{{ number_format(1230000 - $totalYearPay) }}</div>
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
          <div class="flex items-center justify-between rounded bg-[#F7F7F7] px-[10px] py-[20px]">
            <div class="text-sm font-bold">178万</div>
            <div class="flex items-center space-x-[2px]">
              <div class="text-sm font-bold text-[#FF4A62]">{{ number_format(1780000 - $totalYearPay) }}</div>
              <div class="text-xs">円以上で超過</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- デスクトップ版メイン --}}
  <div
    class="flex-1 overflow-x-hidden overflow-y-hidden bg-white lg:h-screen lg:overflow-y-auto lg:bg-[#f4f4f4] lg:p-6">
    <x-main.top>
      <div class="flex w-full items-center justify-center lg:justify-start">
        <button
          class="mr-[5px] flex shrink-0 items-center space-x-1 whitespace-nowrap rounded-l pl-[10px] pr-[5px] text-[15px] leading-none"
          wire:click="selectedMonth('{{ $selectedDate->subMonthNoOverflow()->format('Y-m-d') }}')">
          <img class="block h-[18px] w-[18px]" src="{{ asset('img/icon/arrow-l.png') }}" alt="前月">
          <p class="leading-none">前月</p>
        </button>
        <div class="flex flex-row space-x-[5px]">
          <select class="rounded border border-[#DDDDDD]" wire:model="year" wire:change="updateCalendar">
            @foreach (range(now()->year - 5, now()->year + 5) as $y)
              <option value="{{ $y }}">{{ $y }}年</option>
            @endforeach
          </select>
          <select class="rounded border border-[#DDDDDD]" wire:model="month" wire:change="updateCalendar">
            @foreach (range(1, 12) as $m)
              <option value="{{ $m }}">{{ $m }}月</option>
            @endforeach
          </select>
        </div>
        <button
          class="ml-[5px] flex shrink-0 items-center space-x-1 whitespace-nowrap rounded-r pl-[5px] pr-[10px] text-[15px] leading-none"
          wire:click="selectedMonth('{{ $selectedDate->addMonthNoOverflow()->format('Y-m-d') }}')">
          <p class="leading-none">翌月</p>
          <img class="block h-[18px] w-[18px]" src="{{ asset('img/icon/arrow-r.png') }}" alt="翌月">
        </button>
        <div class="hidden lg:block">
          <button class="mx-[15px] h-[30px] rounded border bg-[#77829C] px-3 text-[14px] text-white"
            wire:click="selectedMonth('{{ now()->format('Y-m-d') }}')">今月</button>
        </div>
      </div>
    </x-main.top>
    <x-main.container>
      <div class="grid grid-cols-7">
        <div class="flex items-center justify-between">
          <div class="mx-auto text-xl font-bold lg:mx-0">{{ $selectedDate->isoFormat('M月') }}</div>
          <div class="hidden text-[15px] lg:block">月</div>
          <div></div>
        </div>
        <div class="hidden items-center justify-center text-[15px] lg:flex">火</div>
        <div class="hidden items-center justify-center text-[15px] lg:flex">水</div>
        <div class="hidden items-center justify-center text-[15px] lg:flex">木</div>
        <div class="hidden items-center justify-center text-[15px] lg:flex">金</div>
        <div class="hidden items-center justify-center text-[15px] text-[#48CBFF] lg:flex">土</div>
        <div class="hidden items-center justify-center text-[15px] text-[#FF0000] lg:flex">日</div>
      </div>
      <div class="mt-[15px] divide-y border lg:grid lg:grid-cols-7 lg:divide-x lg:rounded-lg">
        @foreach ($this->calendar as $content)
          <div @class([
              'lg:min-h-[170px] min-h-[78px] lg:block flex items-center cursor-pointer',
              'justify-between' => $content['workTimes']->isEmpty(),
              'gap-[30px]' => $content['workTimes']->isNotEmpty(),
              'bg-[#F9FAFF]' => $content['date']->isSameDay($selectedDate),
              'bg-gray-100 hidden lg:block' => $content['type'] == '補助日',
          ]) wire:click="clickDate('{{ $content['date']->toDateString() }}')"
            wire:key="calendar-box-{{ $content['date']->toDateString() }}">
            <div @class([
                'px-[15px] py-[15px] text-[15px] flex items-center',
                'text-[#FF0000]' => $content['date']->isoFormat('ddd') === '日',
                'text-[#48CBFF]' => $content['date']->isoFormat('ddd') === '土',
                'font-bold text-[#3289FA]' =>
                    $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d') &&
                    !in_array($content['date']->isoFormat('ddd'), ['土', '日']),
            ])>
              <p class="hidden lg:block">{{ $content['date']->isoFormat('D日') }}</p>
              <div class="text-center text-[12px] font-normal leading-tight lg:hidden">
                <div>{{ $content['date']->isoFormat('D日') }}</div>
                <div>{{ $content['date']->isoFormat('（ddd）') }}</div>
              </div>
            </div>

            @if ($content['workTimes']->isNotEmpty())
              <div
                class="my-2 mr-[15px] min-w-[256px] rounded-lg border border-[#00A1FF] bg-[#F2FBFF] p-[9px] text-[#00A1FF] lg:my-0 lg:mb-[19px] lg:min-h-[108px] lg:min-w-full">
                <div class="flex items-center space-x-[37px] lg:block lg:space-x-0">
                  <div class="text-[12px] font-bold leading-tight">勤務時間</div>
                  <div class="flex flex-col lg:block">
                    @foreach ($content['workTimes'] as $key => $time)
                      <div class="text-[12px] font-bold leading-tight lg:pt-[4px] lg:font-normal">
                        {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->isoFormat('H:mm')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->isoFormat('H:mm')) }}
                      </div>
                    @endforeach
                  </div>
                </div>
                <div class="my-[10px] border-t-[0.5px] border-[#88D3FF]"></div>
                <div class="flex items-center space-x-[37px] lg:block lg:space-x-0">
                  <div class="text-[12px] font-bold leading-tight">休憩時間</div>
                  @if ($content['breakTimes']->isEmpty())
                    <div class="text-[12px] leading-tight lg:pt-[4px]">休憩なし</div>
                  @else
                    <div class="flex flex-col lg:block">
                      @foreach ($content['breakTimes'] as $key => $time)
                        <div class="text-[12px] font-bold leading-tight lg:pt-[4px] lg:font-normal">
                          {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->isoFormat('H:mm')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->isoFormat('H:mm')) }}
                        </div>
                      @endforeach
                    </div>
                  @endif
                </div>
              </div>
            @endif
          </div>
        @endforeach
      </div>
    </x-main.container>
  </div>
</div>
