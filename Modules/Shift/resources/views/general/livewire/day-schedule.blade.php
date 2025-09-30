<x-main.index>
  <x-main.top>
    <div class="flex flex-row items-center space-x-5">
      <div class="hidden flex-row xl:flex">
        <a class="rounded-l border border-[#3289FA] bg-white px-[22px] text-[15px] text-[#3289FA]"
          href="{{ route('shift.schedule', ['category' => 'week']) }}">週</a>
        <a class="rounded-r border border-[#3289FA] bg-[#3289FA] px-[22px] text-[15px] text-white"
          href="{{ route('shift.schedule', ['category' => 'day']) }}">日</a>
      </div>
      <div class="flex items-center md:ml-0">
        <button class="flex items-center space-x-1 rounded-l text-[15px] xl:px-2" wire:click="setPreviousDay">
          <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-l.png') }}" alt="先週">
          <p class="hidden sm:block">前日</p>
        </button>
        <div class="flex flex-row space-x-[5px]">
          <select class="rounded border border-[#DDDDDD]" wire:model.change="viewYear" wire:change="pullDownDateMenu">
            @foreach ($pullDownMenu['year'] as $year)
              <option value="{{ $year }}">{{ $year }}年</option>
            @endforeach
          </select>
          <select class="rounded border border-[#DDDDDD]" wire:model.change="viewMonth" wire:change="pullDownDateMenu">
            @foreach ($pullDownMenu['month'] as $month)
              <option value="{{ $month }}">{{ $month }}月</option>
            @endforeach
          </select>
          <select class="rounded border border-[#DDDDDD]" wire:model.change="viewDay" wire:change="pullDownDateMenu">
            @foreach ($pullDownMenu['day'] as $day)
              <option value="{{ $day }}">{{ $day }}日</option>
            @endforeach
          </select>
        </div>
        <button class="flex items-center space-x-1 rounded-r text-[15px] xl:px-2" wire:click="setNextDay">
          <p class="hidden sm:block">翌日</p>
          <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-r.png') }}" alt="翌週">
        </button>
        <div class="">
          <button class="mx-2 h-[25px] rounded border bg-[#77829C] px-2 text-xs text-white"
            wire:click="setToday">今日</button>
        </div>
      </div>
    </div>
  </x-main.top>
  <x-main.container>
    <div class="flex items-center justify-between">
      <h5 class="text-xl font-bold">シフト表</h5>
      @if ($manager)
        <div class="flex items-center">
          <p class="text-xs">シフト提出依頼：</p>
          <div class="ml-3 flex h-[45px] items-center rounded bg-[#F7F7F7] px-5">
            <div @class([
                'hidden truncate px-[10px] w-fit font-bold sm:block text-xs text-white rounded-full py-[3px]',
                'bg-[#48CBFF]' => $manager->ReceptionStatus === '受付中',
                'bg-[#F76E80]' => $manager->ReceptionStatus === '終了',
                'bg-[#7F8E94]' => $manager->ReceptionStatus === '準備中',
            ])>
              {{ $manager->ReceptionStatus }}
            </div>
            <div class="ml-[11px] font-semibold">{{ $manager->start_date->isoFormat('MM/DD（ddd）') }}～
              {{ $manager->end_date->isoFormat('MM/DD（ddd）') }}</div>
            <a class="ml-[10px] text-xs text-[#3289FA] hover:opacity-40"
              href="{{ route('shift.submission.show', ['manager' => $manager]) }}">シフトを入力する</a>
            <hr class="mx-5 h-5 border-r" />
            <p class="text-xs">期限：</p>
            <div class="ml-[8px] font-semibold text-[#FF4A62]">
              {{ $manager->submission_end_date->isoFormat('YYYY年MM/DD（ddd）まで') }}</div>
          </div>
        </div>
      @endif
    </div>
    <div class="mb-[14px] mt-[17px] flex items-center justify-between">
      <div class="flex items-center">
        <p class="text-xs text-[#AAB0B6]">期間：</p>
        <div class="pl-1 text-xl font-semibold">
          {{ $date->isoFormat('M/D日（ddd）') }}</div>
      </div>
      <a class="flex items-center space-x-1 hover:opacity-40" href="{{ route('shift.submission.index') }}">
        <p class="text-xs text-[#3289FA]">シフト一覧</p>
        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M9.84375 1.40625H13.125C13.2493 1.40625 13.3685 1.45564 13.4565 1.54354C13.5444 1.63145 13.5938 1.75068 13.5938 1.875V5.15625C13.5938 5.28057 13.5444 5.3998 13.4565 5.48771C13.3685 5.57561 13.2493 5.625 13.125 5.625C13.0007 5.625 12.8815 5.57561 12.7935 5.48771C12.7056 5.3998 12.6562 5.28057 12.6562 5.15625V3.00625L5.01875 10.6438C4.92989 10.7266 4.81236 10.7716 4.69092 10.7695C4.56949 10.7673 4.45362 10.7181 4.36774 10.6323C4.28185 10.5464 4.23266 10.4305 4.23052 10.3091C4.22837 10.1876 4.27345 10.0701 4.35625 9.98125L11.9938 2.34375H9.84375C9.71943 2.34375 9.6002 2.29436 9.51229 2.20646C9.42439 2.11855 9.375 1.99932 9.375 1.875C9.375 1.75068 9.42439 1.63145 9.51229 1.54354C9.6002 1.45564 9.71943 1.40625 9.84375 1.40625ZM3.28125 4.21875C3.03261 4.21875 2.79415 4.31752 2.61834 4.49334C2.44252 4.66915 2.34375 4.90761 2.34375 5.15625V11.7188C2.34375 11.9674 2.44252 12.2058 2.61834 12.3817C2.79415 12.5575 3.03261 12.6562 3.28125 12.6562H9.84375C10.0924 12.6562 10.3308 12.5575 10.5067 12.3817C10.6825 12.2058 10.7812 11.9674 10.7812 11.7188V6.5625C10.7812 6.43818 10.8306 6.31895 10.9185 6.23104C11.0065 6.14314 11.1257 6.09375 11.25 6.09375C11.3743 6.09375 11.4935 6.14314 11.5815 6.23104C11.6694 6.31895 11.7188 6.43818 11.7188 6.5625V11.7188C11.7188 12.216 11.5212 12.6929 11.1696 13.0446C10.8179 13.3962 10.341 13.5938 9.84375 13.5938H3.28125C2.78397 13.5938 2.30706 13.3962 1.95542 13.0446C1.60379 12.6929 1.40625 12.216 1.40625 11.7188V5.15625C1.40625 4.65897 1.60379 4.18206 1.95542 3.83042C2.30706 3.47879 2.78397 3.28125 3.28125 3.28125H8.4375C8.56182 3.28125 8.68105 3.33064 8.76896 3.41854C8.85686 3.50645 8.90625 3.62568 8.90625 3.75C8.90625 3.87432 8.85686 3.99355 8.76896 4.08146C8.68105 4.16936 8.56182 4.21875 8.4375 4.21875H3.28125Z"
            fill="#3289FA" />
        </svg>
      </a>
    </div>
    <hr class="border-t">

    <div class="mt-6">
      <div class="sticky -top-6 z-10 flex w-full flex-row bg-white text-xs text-[#6F6C6C]">
        <div class="flex w-32 items-center justify-center">ユーザー名</div>
        <div class="grid h-10 w-full grid-cols-1440">
          @foreach (range(0, 1380, 60) as $start)
            <div @class([
                'col-span-60 flex h-full items-center justify-center',
                'col-start-1' => $start == 0,
                'col-start-61' => $start == 60,
                'col-start-121' => $start == 120,
                'col-start-181' => $start == 180,
                'col-start-241' => $start == 240,
                'col-start-301' => $start == 300,
                'col-start-361' => $start == 360,
                'col-start-421' => $start == 420,
                'col-start-481' => $start == 480,
                'col-start-541' => $start == 540,
                'col-start-601' => $start == 600,
                'col-start-661' => $start == 660,
                'col-start-721' => $start == 720,
                'col-start-781' => $start == 780,
                'col-start-841' => $start == 840,
                'col-start-901' => $start == 900,
                'col-start-961' => $start == 960,
                'col-start-1021' => $start == 1020,
                'col-start-1081' => $start == 1080,
                'col-start-1141' => $start == 1140,
                'col-start-1201' => $start == 1200,
                'col-start-1261' => $start == 1260,
                'col-start-1321' => $start == 1320,
                'col-start-1381' => $start == 1380,
            ])>
              {{ $start / 60 }}:00
            </div>
          @endforeach
        </div>
      </div>
      @foreach ($userShiftSchedules as $shiftSchedules)
        <div class="flex w-full flex-row">
          <div @class([
              'flex w-32 items-center justify-start border px-[25px] text-[15px] font-bold',
              'rounded-tl-lg' => $loop->first,
              'rounded-bl-lg' => $loop->last,
          ])>{{ $shiftSchedules['name'] }}</div>
          <div class="relative grid h-[120px] w-full grid-cols-1440 items-center">
            @foreach (range(0, 1380, 60) as $start)
              <div @class([
                  'col-span-60 flex h-full items-center justify-center border',
                  'col-start-1' => $start == 0,
                  'col-start-61' => $start == 60,
                  'col-start-121' => $start == 120,
                  'col-start-181' => $start == 180,
                  'col-start-241' => $start == 240,
                  'col-start-301' => $start == 300,
                  'col-start-361' => $start == 360,
                  'col-start-421' => $start == 420,
                  'col-start-481' => $start == 480,
                  'col-start-541' => $start == 540,
                  'col-start-601' => $start == 600,
                  'col-start-661' => $start == 660,
                  'col-start-721' => $start == 720,
                  'col-start-781' => $start == 780,
                  'col-start-841' => $start == 840,
                  'col-start-901' => $start == 900,
                  'col-start-961' => $start == 960,
                  'col-start-1021' => $start == 1020,
                  'col-start-1081' => $start == 1080,
                  'col-start-1141' => $start == 1140,
                  'col-start-1201' => $start == 1200,
                  'col-start-1261' => $start == 1260,
                  'col-start-1321' => $start == 1320,
                  'col-start-1381' => $start == 1380,
              ])>
              </div>
            @endforeach

            <div class="absolute h-[60px] w-full">
              <div class="col grid h-full grid-cols-1440 py-1">
                @foreach ($shiftSchedules['schedules'] as $shiftSchedule)
                  @include('shift::general.layouts.time', ['shiftSchedule' => $shiftSchedule])
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- <div class="fixed inset-0 bg-white" id="printArea" x-show="showPrintArea" x-transition>
      <div class="flex justify-center text-xl font-bold">{{ $date->isoFormat('M/D(ddd)') }}</div>
      <div class="flex w-full flex-row bg-gray-100">
        <div class="flex w-32 items-center justify-center border">ユーザー名</div>
        <div class="grid h-20 w-full grid-cols-1440">
          @foreach (range(0, 1380, 60) as $start)
            <div @class([
                ' col-span-60 flex h-20 items-center justify-center border',
                'col-start-1' => $start == 0,
                'col-start-61' => $start == 60,
                'col-start-121' => $start == 120,
                'col-start-181' => $start == 180,
                'col-start-241' => $start == 240,
                'col-start-301' => $start == 300,
                'col-start-361' => $start == 360,
                'col-start-421' => $start == 420,
                'col-start-481' => $start == 480,
                'col-start-541' => $start == 540,
                'col-start-601' => $start == 600,
                'col-start-661' => $start == 660,
                'col-start-721' => $start == 720,
                'col-start-781' => $start == 780,
                'col-start-841' => $start == 840,
                'col-start-901' => $start == 900,
                'col-start-961' => $start == 960,
                'col-start-1021' => $start == 1020,
                'col-start-1081' => $start == 1080,
                'col-start-1141' => $start == 1140,
                'col-start-1201' => $start == 1200,
                'col-start-1261' => $start == 1260,
                'col-start-1321' => $start == 1320,
                'col-start-1381' => $start == 1380,
            ])>
              {{ $start / 60 }}:00
            </div>
          @endforeach
        </div>
      </div>
      @foreach ($userShiftSchedules as $shiftSchedules)
        <div class="flex w-full flex-row">
          <div class="flex w-32 items-center justify-center border">{{ $shiftSchedules['name'] }}</div>
          <div class="relative grid h-20 w-full grid-cols-1440">
            @foreach (range(0, 1380, 60) as $start)
              <div @class(['col-span-60 flex h-20 items-center justify-center border'])>
              </div>
            @endforeach

            <div class="absolute h-full w-full">
              <div class="col grid h-full grid-cols-1440 py-2">
                @foreach ($shiftSchedules['schedules'] as $shiftSchedule)
                  @include('shift::general.layouts.time', ['shiftSchedule' => $shiftSchedule])
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div> --}}
    {{-- 
    <style>
      @media print {
        @page {
          size: A4 landscape;
          margin: 2%;
        }
      }

      #printArea {
        transform: scale(0.5);
        transform-origin: top left;
        width: 200%;
        height: 200%;
      }
    </style> --}}

  </x-main.container>
</x-main.index>
