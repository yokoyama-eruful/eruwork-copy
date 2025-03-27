<x-app-layout>
  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2">
        <div class="h-auto self-stretch border-l-4 border-ao-main"></div>
        <div class="text-lg font-bold">本日のシフト</div>
      </div>
      <a class="text-ao-main hover:text-sky-700" href="{{ route('schedule.index') }}">
        詳しく見る
        <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
    </div>

    <div class="hidden xl:block">
      <div class="sticky -top-6 z-0 flex w-full flex-row bg-gray-100">
        <div class="flex w-32 items-center justify-center border">ユーザー名</div>
        <div class="grid h-10 w-full grid-cols-1440">
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
              {{ $start / 60 }}:00
            </div>
          @endforeach
        </div>
      </div>
      @foreach ($userSchedules as $shiftSchedules)
        <div class="flex w-full flex-row">
          <div class="flex w-32 items-center justify-center border">{{ $shiftSchedules['name'] }}</div>
          <div class="relative grid h-12 w-full grid-cols-1440">
            @foreach (range(0, 1380, 60) as $start)
              <div @class([
                  'flex  col-span-60 h-full items-center justify-center border',
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
                  @include('shift::general.layouts.time', ['shiftSchedule' => $shiftSchedule])
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="block w-full xl:hidden">
      <table class="w-full border-collapse border border-gray-200">
        <tbody>
          @foreach ($userSchedules as $shiftSchedules)
            @foreach ($shiftSchedules['schedules'] as $index => $shiftSchedule)
              <tr>
                @if ($index === 0)
                  <td class="border border-gray-200 px-2 py-1" rowspan="{{ count($shiftSchedules['schedules']) }}">
                    {{ $shiftSchedules['name'] }}</td>
                @endif
                <td class="border border-gray-200 px-2 py-1">{{ $shiftSchedule->viewSchedule }}</td>
              </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </x-widget>

  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2">
        <div class="h-auto self-stretch border-l-4 border-ao-main"></div>
        <div class="text-lg font-bold">シフト提出</div>
      </div>
    </div>
    <div class="w-full">
      @foreach ($managers as $manager)
        @if ($manager->ReceptionStatus == '受付中' || $manager->ReceptionStatus == '受付終了')
          <a class="mb-2 flex flex-wrap items-center justify-between rounded-md border px-4 py-2 shadow hover:bg-sky-50"
            href="{{ route('submission.show', ['manager' => $manager->id]) }}">
            <div class="flex flex-col">
              <div class="flex flex-col sm:flex-row sm:space-x-1">
                <div class="font-semibold">{{ $manager->viewSchedule }}</div>
              </div>
              <div class="flex flex-wrap justify-between space-x-1 font-medium xl:flex-row">
                <div>締め切り:{{ $manager->submission_end_date->format('Y年m月d日') }}</div>
                <div @class([
                    'inline-block rounded px-4 text-white xl:hidden block',
                    'bg-sky-400' => $manager->ReceptionStatus == '受付中',
                    'bg-rose-400' => $manager->ReceptionStatus == '受付終了',
                ])>
                  {{ $manager->ReceptionStatus }}
                </div>
              </div>
            </div>

            <div @class([
                'inline-block rounded p-2 px-4 text-white xl:block hidden',
                'bg-sky-400' => $manager->ReceptionStatus == '受付中',
                'bg-rose-400' => $manager->ReceptionStatus == '受付終了',
            ])>
              {{ $manager->ReceptionStatus }}
            </div>
          </a>
        @endif
      @endforeach
    </div>
  </x-widget>
</x-app-layout>
