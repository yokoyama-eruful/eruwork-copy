<x-widget>
  <div class="flex flex-wrap items-center justify-between pb-2">
    <div class="flex flex-row items-center space-x-2 py-2">
      <div class="h-auto self-stretch border-l-4 border-hai-main"></div>
      <div class="text-lg font-bold">シフト管理</div>
    </div>
  </div>
  <div class="mb-2 flex flex-row gap-2">
    <div class="flex min-h-20 w-1/2 cursor-pointer flex-col px-4 text-base">
      <div class="flex flex-row items-center space-x-2 text-xl">
        <div class="bg-sky-300 px-4 py-1">今日</div>
        <div>{{ now()->isoFormat('M月D日(ddd)') }}</div>
      </div>
      <div class="text-xl">
        @foreach ($todayShiftList as $name => $schedules)
          <div class="pb-1">
            <div class="mb-1">
              {{ $name }}
            </div>
            <div class="-ms-4 -mt-1 text-center">
              @foreach ($schedules as $schedule)
                <div class="pb-1">
                  {{ $schedule->start_time->format('H:i') . '～' . $schedule->end_time?->format('H:i') }}
                </div>
              @endforeach
            </div>
            <hr class="border-b border-dashed border-gray-400">
          </div>
        @endforeach
      </div>
    </div>
    <div class="flex min-h-20 w-1/2 cursor-pointer flex-col px-4 text-base">
      <div class="flex flex-row items-center space-x-2 text-xl">
        <div class="bg-sky-200 px-4 py-1">明日</div>
        <div>{{ now()->addDay()->isoFormat('M月D日(ddd)') }}</div>
      </div>
      <div class="text-xl">
        @foreach ($tomorrowShiftList as $name => $schedules)
          <div class="py-1">
            <div class="mb-1">
              {{ $name }}
            </div>
            <div class="-ms-4 -mt-1 text-center">
              @foreach ($schedules as $schedule)
                <div class="pb-1">
                  {{ $schedule->start_time->format('H:i') . '～' . $schedule->end_time?->format('H:i') }}
                </div>
              @endforeach
            </div>
            <hr class="border-b border-dashed border-gray-400">
          </div>
        @endforeach
      </div>
    </div>
</x-widget>
