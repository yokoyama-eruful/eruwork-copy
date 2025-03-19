<div class="hidden xl:block">
  <x-widget>
    <div class="flex justify-between">
      <div class="mb-2 flex items-center justify-end gap-1">
        <h1 class="text-2xl font-bold">{{ $startDate->format('Y年n月') }}</h1>
        <button
          class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
          wire:click="setPreviousWeek">
          <i class="fa-solid fa-angles-left"></i> 前週
        </button>
        <button
          class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
          wire:click="setPreviousDay">
          <i class="fa-solid fa-angle-left"></i> 前日
        </button>
        <button
          class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
          wire:click="setToday">
          今日
        </button>
        <button
          class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
          wire:click="setNextDay">
          翌日<i class="fa-solid fa-chevron-right"></i>
        </button>
        <button
          class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
          wire:click="setNextWeek">
          翌週<i class="fa-solid fa-angles-right"></i>
        </button>
      </div>

    </div>
    <div class="flex justify-center">
      <div class="flex w-full overflow-x-auto">
        @foreach ($this->calendar as $key => $content)
          <div class=
                'm-0 mb-3 min-h-48 min-w-56 border md:w-1/6'>
            <div @class([
                'text-lg w-full border-b flex justify-center py-1 bg-ao-sub',
                'bg-rose-200' => $content['type'] === '土曜日',
                'bg-sky-200' => $content['type'] === '日曜日',
                'bg-orange-200' => $content['type'] === '公休日',
            ])>
              {{ $content['date']->isoFormat('MM/DD(ddd)') }}{{ $content['date_name'] }}
            </div>
            <div class="m-2 flex justify-end">
              <livewire:calendar::create-schedule :date="$content['date']" :key="$content['date']->format('Ymd') . $key" />
              {{-- @livewire('Calendar.CreateSchedule', ['date' => $content['date']], key($content['date']->format('Ymd') . $key . now()->format('His'))) --}}
            </div>
            <div class="mt-2 flex flex-col gap-1">
              @foreach ($this->shiftSchedules[$content['date']->format('Y-m-d')] as $schedule)
                {{-- <x-dialog>
                <x-dialog.open>
                  <div class="mx-1 mb-1 cursor-pointer truncate rounded bg-teal-400 pb-1 ps-1">
                    <div class="flex justify-between">
                      <div class="underline decoration-gray-400">
                        {{ $schedule->label }}
                      </div>
                      @if ($this->overlappingSchedules($schedule) || $this->overlappingShifts($schedule))
                        <i class="fa-solid fa-circle-exclamation p-1 text-rose-600"></i>
                      @endif
                    </div>
                    <div class="ms-1">
                      {{ $schedule->start_time->format('H:i') . '～' . $schedule->end_time?->format('H:i') }}
                    </div>
                  </div>
                </x-dialog.open>
                <x-dialog.panel title="シフト">
                  <div class="flex justify-between">
                    <div class="text-xl font-bold">
                      {{ $schedule->date->isoFormat('YYYY年M月D日(ddd)') }}
                    </div>
                  </div>
                  @if ($this->overlappingSchedules($schedule) || $this->overlappingShifts($schedule))
                    <div><i class="fa-solid fa-circle-exclamation p-1 text-rose-600"></i>予定が重複しています</div>
                  @endif
                  <hr class="w-11/12">
                  <div class="flex flex-col">
                    <label class="flex items-center gap-x-4 py-4">
                      <span class="w-24 whitespace-nowrap">開始時刻</span>
                      <div class="flex-1 border-b border-slate-300 px-3 py-2 font-normal read-only:cursor-not-allowed">
                        {{ $schedule->start_time->format('H:i') }}
                      </div>
                    </label>
                    <label class="flex items-center gap-x-4 py-4">
                      <span class="w-24 whitespace-nowrap">終了時刻</span>
                      <div class="flex-1 border-b border-slate-300 px-3 py-2 font-normal read-only:cursor-not-allowed">
                        {{ $schedule->end_time->format('H:i') }}
                      </div>
                    </label>

                    <x-dialog.footer>
                      <x-dialog.cancel>
                        キャンセル
                      </x-dialog.cancel>
                    </x-dialog.footer>
                  </div>
                </x-dialog.panel>
              </x-dialog> --}}
              @endforeach
              @foreach ($this->schedules[$content['date']->format('Y-m-d')] as $schedule)
                @livewire('Calendar.EditSchedule', ['schedule' => $schedule], key($schedule->date->format('Ymd') . $key . $schedule->id))
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </x-widget>
</div>
