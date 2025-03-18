<div x-data="{ showPrintArea: false }">
  <div class="flex flex-row items-center space-x-5">
    <div class="flex flex-row">
      <button class="flex items-center justify-center border border-ao-main px-7 text-ao-main hover:bg-ao-sub"
        @click="schedule = 'week'">週</button>
      <button class="flex items-center justify-center border border-ao-main bg-ao-main px-7 text-white"
        @click="schedule = 'day'">日</button>
    </div>
    <div class="text-xl font-bold">{{ $date->isoFormat('Y/M/D(ddd)') }}</div>
  </div>

  <div class="my-3 flex items-center justify-between">
    <div class="flex flex-row items-center md:ml-0">
      <button
        class="flex h-10 items-center space-x-1 rounded-l bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
        wire:click="setPreviousDay">
        <i class="fa-solid fa-chevron-left"></i>
        <p>前日</p>
      </button>
      <div class="flex flex-row">
        <select class="h-10" wire:model.change="viewYear" wire:change="pullDownDateMenu">
          @foreach ($pullDownMenu['year'] as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="h-10" wire:model.change="viewMonth" wire:change="pullDownDateMenu">
          @foreach ($pullDownMenu['month'] as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
        <select class="h-10" wire:model.change="viewDay" wire:change="pullDownDateMenu">
          @foreach ($pullDownMenu['day'] as $day)
            <option value="{{ $day }}">{{ $day }}日</option>
          @endforeach
        </select>
      </div>
      <button
        class="flex h-10 items-center space-x-1 rounded-r bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
        wire:click="setNextDay">
        <p>翌日</p>
        <i class="fa-solid fa-chevron-right"></i>
      </button>
      <div class="h-10">
        <button class="mx-2 h-10 rounded border bg-ao-sub px-2 hover:bg-ao-main" wire:click="setToday">今日</button>
      </div>
    </div>

    <div class="flex items-center justify-end gap-2">
      <input class="h-5 w-5" type="checkbox" value="出勤" wire:model.live="selected">
      出勤者のみ表示
      <button
        class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
        type="button"
        @click="showPrintArea = !showPrintArea; $nextTick(() => { setTimeout(() => { if (showPrintArea) window.print() }, 200);setTimeout(() => { if (showPrintArea) showPrintArea=!showPrintArea  }, 210) })">
        印刷<i class="fa-solid fa-print pl-1"></i>
      </button>
    </div>
  </div>

  <div>
    <div class="sticky -top-6 z-0 flex w-full flex-row bg-gray-100">
      <div class="flex w-32 items-center justify-center border">ユーザー名</div>
      <div class="grid h-10 w-full grid-cols-1440">
        @foreach (range(0, 1380, 60) as $start)
          <div @class([
              ' col-span-60 flex h-full items-center justify-center border',
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
        <div class="relative grid h-12 w-full grid-cols-1440">
          @foreach (range(0, 1380, 60) as $start)
            <div @class([
                ' col-span-60 flex h-full items-center justify-center border',
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

          <div class="absolute h-full w-full">
            <div class="col grid h-full grid-cols-1440 py-1">
              @foreach ($shiftSchedules['schedules'] as $shiftSchedule)
                @include('shift::layouts.time', ['shiftSchedule' => $shiftSchedule])
              @endforeach
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="fixed inset-0 bg-white" id="printArea" x-show="showPrintArea" x-transition>
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
                @include('shift::layouts.time', ['shiftSchedule' => $shiftSchedule])
              @endforeach
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

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
  </style>

</div>
